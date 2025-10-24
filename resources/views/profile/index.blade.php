@extends("layouts.app")

@section("title", "Your profile")

@section("content")
    <h1 class="title">Welcome back, {{ $user->mu_name }}!</h1>
    <form method="POST" action="{{ route("profile.update") }}" class="mb-8">
        @csrf
        @method("PATCH")

        <div class="gap-4 grid mb-4">
            <x-mm-input
                label="Your nickname"
                name="name"
                error_name="mu_name"
                value="{{ old('name', $user->mu_name) }}"
            />

            <x-mm-input
                label="Your email"
                name="email"
                type="email"
                error_name="mu_email"
                value="{{ old('email', $user->mu_email) }}"
            />
        </div>

        <div class="grid space-y-2">
            <x-mm-button label="Save Changes" />
            <a
                href="{{ route("logout") }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-mm-red bg-white px-5 py-2.5 rounded-lg text-sm text-center transition-colors hover:text-white hover:bg-mm-red"
            >
                Log out
            </a>
        </div>
    </form>

    <form
        id="logout-form"
        action="{{ route("logout") }}"
        method="POST"
        class="hidden"
    >
        @csrf
    </form>

    <h2 class="title">Want to change your password?</h2>
    <x-mm-password-update />
@endsection
