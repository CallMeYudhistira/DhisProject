<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class ThrottleRequests
{
    protected $maxAttempts = 20; // jumlah request
    protected $decaySeconds = 60; // per berapa detik

    public function handle($request, Closure $next)
    {
        $key = $this->resolveRequestSignature($request);

        $attempts = Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            return view('429');
        }

        Cache::put($key, $attempts + 1, $this->decaySeconds);

        return $next($request);
    }

    protected function resolveRequestSignature($request)
    {
        return sha1(
            $request->ip() . '|' .
            $request->method() . '|' .
            $request->path()
        );
    }
}
