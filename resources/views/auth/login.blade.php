@extends("layouts.form-centered")

@section("title", "Login")

@section("content")
    <div
        class="max-w-full w-full md:max-w-xl md:w-a md:mx-auto bg-mm-card p-6 rounded-lg shadow-lg"
    >
        <h1 class="text-2xl text-white font-semibold mb-4">Login</h1>

        <form
            method="POST"
            action="{{ route("login.post") }}"
            class="space-y-4"
        >
            @csrf

            <x-mm-input label="Email" name="email" required />

            <x-mm-input
                label="Password"
                name="password"
                type="password"
                required
            />

            <div class="mb-4 flex items-center">
                <label class="inline-flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        class="mr-2 text-mm-orange focus:ring-orange-500"
                        {{ old("remember") ? "checked" : "" }}
                    />
                    <span class="text-sm text-mm-light-gray">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <x-mm-button label="Sign in" />
                <a
                    href="{{ route("register") }}"
                    class="text-sm text-mm-orange hover:text-mm-orange--hover underline"
                >
                    Create account
                </a>
            </div>
            <div class="mt-4 text-center">
                <x-social-button
                    label="Login with Google"
                    href="{{ route('auth.google.redirect') }}"
                    class="bg-mm-dark-blue text-white hover:bg-mm-border transition"
                />
            </div>
        </form>
    </div>
@endsection
