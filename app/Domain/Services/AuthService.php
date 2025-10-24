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
        } catch (JWTException $e) {
            throw new \RuntimeException('Could not create token');
        }

        return [
          'token' => $token,
          'user' => $user,
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
        } catch (JWTException $e) {
            throw new \RuntimeException('Could not create token');
        }

        return [
          'token' => $token,
          'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ];
    }

    public function logout(?string $token = null): JsonResponse
    {
        try {
            $token = $token ?? JWTAuth::getToken();

            if ($token) {
                JWTAuth::setToken($token)->invalidate();
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
