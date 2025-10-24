<?php

namespace App\Http\Controllers\Web;

use App\Domain\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $auth_service)
    {
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        try {
            $resp = $this->auth_service->login($data);
        } catch (\Throwable $e) {
            Log::error('Auth API call failed: ' . $e->getMessage());

            return back()->withInput($request->only('email', 'remember'))
                ->with('error', $e->getMessage());
        }

        $token = $resp['token'] ?? null;

        if (!$token) {
            return back()->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Authentication failed (no token returned).']);
        }

        $ttl = (int)config('jwt.ttl', 60);

        $cookie = cookie(
            'jwt',
            $token,
            $ttl,
            '/',
            null,
            app()->environment('production'), // secure only in production
            true,
            false,
            'Lax'
        );

        try {
            $user = JWTAuth::setToken($token)->authenticate();

            if ($user instanceof \Illuminate\Contracts\Auth\Authenticatable) {
                Auth::login($user, (bool)($data['remember'] ?? false));
            }
        } catch (JWTException $e) {
            Log::warning('JWT parse after API login failed: ' . $e->getMessage());
        }

        return redirect()->intended(route('profile'))->withCookie($cookie)->with('success', 'Signed in successfully.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        try {
            $resp = $this->auth_service->register($data);
        } catch (\Throwable $e) {
            Log::error('Auth register failed: ' . $e->getMessage());

            return back()->withInput($request->only('name', 'email'))
                ->withErrors(['email' => 'Registration failed.']);
        }

        $token = $resp['token'] ?? null;

        if (!$token) {
            return back()->withInput($request->only('name', 'email'))
                ->withErrors(['email' => 'Registration succeeded but token missing.']);
        }

        $ttl = (int)config('jwt.ttl', 60);

        $cookie = cookie('jwt', $token, $ttl, '/', null, app()->environment('production'), true, false, 'Lax');

        try {
            $user = JWTAuth::setToken($token)->authenticate();

            if ($user instanceof \Illuminate\Contracts\Auth\Authenticatable) {
                Auth::login($user);
            }
        } catch (JWTException $e) {
            Log::warning('JWT parse after API register failed: ' . $e->getMessage());
        }

        return redirect()->intended(route('profile'))->withCookie($cookie)->with('success', 'Account created and signed in.');
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        $token = $request->cookie('jwt') ?? JWTAuth::getToken();

        if ($token) {
            $this->auth_service->logout($token);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $forget = Cookie::forget('jwt');

        return redirect()->route('login')->withCookie($forget)->with('success', 'You have been logged out.');
    }
}
