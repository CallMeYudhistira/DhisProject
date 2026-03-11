<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class ShieldFirewall
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        $path = $request->path();
        $ua = $request->userAgent() ?? 'unknown';

        $fingerprint = sha1($ip.$ua);
        $now = time();

        // ===== 1. Blacklist Check =====
        if (Cache::has("block:$ip")) {
            return view('403');
        }

        // ===== 2. Burst Detection =====
        $burstKey = "burst:$ip";
        $burst = Cache::get($burstKey, []);

        $burst[] = $now;
        $burst = array_filter($burst, fn($t) => $t > $now - 5);

        if (count($burst) > 25) {
            Cache::put("block:$ip", true, 600);
            return view('429');
        }

        Cache::put($burstKey, $burst, 10);

        // ===== 3. Endpoint Pattern Attack =====
        $pathKey = "path:$ip:$path";
        $hits = Cache::increment($pathKey);
        Cache::put($pathKey, $hits, 60);

        if ($hits > 80) {
            Cache::put("block:$ip", true, 600);
            return view('429');
        }

        // ===== 4. Suspicious User Agent & Bots =====
        $badAgents = [
            'curl','python','wget','scrapy','httpclient','bot','spider','crawl',
            'libwww','zgrab','censys','sqlmap','nmap','burp','acunetix','hydra'
        ];

        foreach ($badAgents as $bad) {
            if (stripos($ua, $bad) !== false) {
                Cache::increment("sus:$ip", 5); // Heavier penalty for known bots/tools
            }
        }

        // ===== 5. Malicious Pattern Detection (Simple XSS/SQLi) =====
        $query = $request->fullUrl();
        $maliciousPatterns = [
            '/<script/i', '/union\s+select/i', '/exec\s*\(/i', '/base64_/i',
            '/[\'"]\s*or\s*[\'"]?\d/i', '/drop\s+table/i', '/<iframe/i'
        ];

        foreach ($maliciousPatterns as $pattern) {
            if (preg_match($pattern, $query) || preg_match($pattern, json_encode($request->all()))) {
                Cache::put("block:$ip", true, 3600); // Block for 1 hour immediately
                return view('403');
            }
        }

        // ===== 6. Suspicion Score System =====
        $sus = Cache::get("sus:$ip", 0);

        if ($sus >= 15) {
            Cache::put("block:$ip", true, 3600); // Block for 1 hour
            return view('403');
        }

        // ===== 7. Adaptive Rate Limit =====
        $rateKey = "rate:$fingerprint";
        $rate = Cache::increment($rateKey);
        Cache::put($rateKey, $rate, 60);

        // More restrictive if suspicious
        $limit = $sus > 5 ? 15 : 45;

        if ($rate > $limit) {
            return view('429', ['seconds' => 60]);
        }

        return $next($request);
    }
}
