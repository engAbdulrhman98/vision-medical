<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictIpAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIpsStr = env('ADMIN_ALLOWED_IPS');

        // If no allowed IPs are specified, we let the request through.
        if (empty($allowedIpsStr)) {
            return $next($request);
        }

        $allowedIps = array_map('trim', explode(',', $allowedIpsStr));

        // Validate client IP against the allowed whitelist.
        if (!in_array($request->ip(), $allowedIps)) {
            abort(404);
        }

        return $next($request);
    }
}
