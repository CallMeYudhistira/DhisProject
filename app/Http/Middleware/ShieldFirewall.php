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

        // ===== 4. Suspicious User Agent =====
        $badAgents = ['curl','python','wget','scrapy','httpclient'];

        foreach ($badAgents as $bad) {
            if (stripos($ua,$bad) !== false) {
                Cache::increment("sus:$ip");
            }
        }

        // ===== 5. Suspicion Score System =====
        $sus = Cache::get("sus:$ip",0);

        if ($sus >= 10) {
            Cache::put("block:$ip", true, 1200);
            return view('403');
        }

        // ===== 6. Adaptive Rate Limit =====
        $rateKey = "rate:$fingerprint";
        $rate = Cache::increment($rateKey);
        Cache::put($rateKey,$rate,60);

        $limit = $sus > 5 ? 20 : 60;

        if ($rate > $limit) {
            return view('429');
        }

        return $next($request);
    }
}
