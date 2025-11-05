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
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user || !in_array($user->mu_role, $roles)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['error' => 'User does not have the right role.'], 403);
            }

            return redirect()->guest(route('dashboard'))->with('error', 'User does not have the right role.');
        }

        return $next($request);
    }
}
