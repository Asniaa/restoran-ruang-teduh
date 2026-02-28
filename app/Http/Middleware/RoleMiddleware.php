<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if user's role is in the allowed $roles array
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
