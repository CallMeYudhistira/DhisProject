<?php

namespace App\Http\Middleware;

use Closure;

class ThrottleRequests
{
    protected $maxAttempts = 20;
    protected $decaySeconds = 60;

    public function handle($request, Closure $next)
    {
        $key = $this->resolveRequestSignature($request);

        $redis = new \Redis();
        $redis->connect(env('REDIS_HOST', 'redis'), env('REDIS_PORT', 6379));

        $attempts = $redis->incr($key);

        // set TTL hanya saat pertama kali dibuat
        if ($attempts == 1) {
            $redis->expire($key, $this->decaySeconds);
        }

        if ($attempts > $this->maxAttempts) {

            $ttl = $redis->ttl($key);

            return response(
                view('429', [
                    'seconds' => $ttl > 0 ? $ttl : $this->decaySeconds
                ]),
                429
            );
        }

        return $next($request);
    }

    protected function resolveRequestSignature($request)
    {
        return sha1(
            $request->ip().'|'.
            $request->method().'|'.
            $request->path()
        );
    }
}
