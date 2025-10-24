<?php

namespace App\Http\Controllers\Web;

use App\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleAuthController extends Controller
{
    public function __construct(private readonly UserRepositoryInterface $users)
    {
    }

    /**
     * Redirect the user to Google’s OAuth page.
     */
    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        try {
            /** @var \Laravel\Socialite\Two\AbstractProvider $provider */
            $provider = Socialite::driver('google');

            $google_user = $provider->stateless()->user();
        } catch (Throwable $e) {
            return redirect('/login')->with('error', 'Google authentication failed.');
        }

        $user = $this->users->findByEmail($google_user->getEmail());

        if (!$user) {
            $user = $this->users->create([
                'mu_name' => $google_user->getName(),
                'mu_email' => $google_user->getEmail(),
                'mu_password' => Hash::make(Str::random(16)),
                'mu_email_verified_at' => now(),
                'mu_role' => 'user',
            ]);
        } else {
            $user->update(['mu_name' => $google_user->getName()]);
        }

        Auth::logout();
        Auth::login($user);

        $token = JWTAuth::fromUser($user);
        $ttl = (int)config('jwt.ttl', 60);

        $cookie = cookie('jwt', $token, $ttl, '/', null, app()->environment('production'), true, false, 'Lax');

        // Redirect with token (e.g., to Vue frontend or inject into response)
        return redirect()->intended(route('profile'))->withCookie($cookie)->with('success', 'Signed in successfully.');
    }
}
