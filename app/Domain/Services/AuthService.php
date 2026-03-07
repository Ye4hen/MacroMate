<?php

namespace App\Domain\Services;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

readonly class AuthService
{
    public function __construct(
        private UserRepositoryInterface $users
    ) {
    }

    public function register(array $data): array
    {
        $user = $this->users->create([
          'mu_name' => $data['name'],
          'mu_email' => $data['email'],
          'mu_password' => Hash::make($data['password']),
        ]);

        try {
            $token = JWTAuth::fromUser($user);
            $ttl = (int)config('jwt.ttl', 60);
            $server_cookie = cookie('jwt', $token, $ttl, '/', null, app()->environment('production'), true, false, 'Lax');
            $client_cookie = cookie(
                'is_authenticated',
                'true',
                $ttl,
                '/',
                null,
                app()->environment('production'),
                false,
                false,
                'Lax'
            );
        } catch (JWTException $e) {
            throw new \RuntimeException('Could not create token');
        }

        return [
          'token' => $token,
          'user' => $user,
          'client_cookie' => $client_cookie,
          'server_cookie' => $server_cookie,
        ];
    }

    public function login(array $credentials): array
    {
        $jwt_credentials = [
          'mu_email' => $credentials['email'],
          'password' => $credentials['password'],
        ];

        try {
            if (!$token = JWTAuth::attempt($jwt_credentials)) {
                throw new \RuntimeException('Invalid credentials');
            }
            $user = $this->users->findByEmail($credentials['email']);
            $ttl = (int)config('jwt.ttl', 60);
            $server_cookie = cookie('jwt', $token, $ttl, '/', null, app()->environment('production'), true, false, 'Lax');
            $client_cookie = cookie(
                'is_authenticated',
                'true',
                $ttl,
                '/',
                null,
                app()->environment('production'),
                false,
                false,
                'Lax'
            );
        } catch (JWTException $e) {
            throw new \RuntimeException('Could not create token');
        }

        return [
          'token' => $token,
          'user' => $user,
          'client_cookie' => $client_cookie,
          'server_cookie' => $server_cookie,
        ];
    }

    public function logout(?string $token = null): JsonResponse
    {
        try {
            $token = $token ?? JWTAuth::getToken();
            cookie()->forget('jwt');
            cookie()->forget('is_authenticated');

            if ($token) {
                JWTAuth::setToken($token)->invalidate();
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
