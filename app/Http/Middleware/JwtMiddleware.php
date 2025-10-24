<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->bearerToken()) {
            $token_from_cookie = $request->cookie('jwt');

            if (!empty($token_from_cookie)) {
                $request->headers->set('Authorization', 'Bearer ' . $token_from_cookie);
            }
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return $this->unauthorizedResponse($request);
            }

            if ($user instanceof \Illuminate\Contracts\Auth\Authenticatable) {
                auth()->setUser($user);
            }

            View::share('user', $user);
        } catch (TokenExpiredException $e) {
            Log::info('JWT token expired: ' . $e->getMessage());

            return $this->unauthorizedResponse($request, 'Token expired');
        } catch (TokenInvalidException $e) {
            Log::info('JWT token invalid: ' . $e->getMessage());

            return $this->unauthorizedResponse($request, 'Token invalid');
        } catch (JWTException $e) {
            Log::info('JWT auth error: ' . $e->getMessage());

            return $this->unauthorizedResponse($request);
        } catch (\Exception $e) {
            Log::warning('Unexpected JWT exception: ' . $e->getMessage());

            return $this->unauthorizedResponse($request);
        }

        return $next($request);
    }

    protected function unauthorizedResponse(Request $request, string $message = 'Unauthorized', int $status = 401): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['error' => $message], $status);
        }

        return redirect()->guest(route('login'))->with('error', $message);
    }
}
