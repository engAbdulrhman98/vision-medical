<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedUser = env('ADMIN_BASIC_AUTH_USER', 'admin');
        $expectedPass = env('ADMIN_BASIC_AUTH_PASS', 'visionadmin123');

        // Check credentials from the Authorization header
        if ($request->getUser() !== $expectedUser || $request->getPassword() !== $expectedPass) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Vision Medical Admin Protection", charset="UTF-8"'
            ]);
        }

        return $next($request);
    }
}
