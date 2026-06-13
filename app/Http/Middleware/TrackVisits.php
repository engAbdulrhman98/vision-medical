<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't track admin panel pages
        if (!$request->is('admin*') && !$request->is('login*')) {
            try {
                $ip = $request->ip();
                $date = now()->toDateString();
                
                // Track unique IP per day
                Visit::firstOrCreate([
                    'ip_address' => $ip,
                    'visit_date' => $date
                ]);
            } catch (\Exception $e) {
                // Fail silently to not disrupt the user if database has issues
                logger('Failed to track visit: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
