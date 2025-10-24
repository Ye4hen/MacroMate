@extends("layouts.form-centered")

@section("title", "Register")

@section("content")
    <div
        class="max-w-full w-full md:max-w-xl md:w-a md:mx-auto bg-mm-card p-6 rounded-lg shadow-lg"
    >
        <h1 class="text-2xl text-white font-semibold mb-4">Create account</h1>

        <form
            method="POST"
            action="{{ route("register.post") }}"
            class="space-y-4"
        >
            @csrf

            <x-mm-input label="Name" name="name" required autofocus />

            <x-mm-input label="Email" name="email" required />

            <x-mm-input
                label="Password"
                name="password"
                type="password"
                required
            />

            <x-mm-input
                label="Confirm Password"
                name="password_confirmation"
                type="password"
                required
            />

            <div class="flex items-center justify-between">
                <x-mm-button label="Create account" />
                <a
                    href="{{ route("login") }}"
                    class="text-sm text-mm-orange hover:text-mm-orange--hover underline"
                >
                    Already have an account?
                </a>
            </div>
            <div class="mt-4 text-center">
                <x-social-button
                    label="Register with Google"
                    href="{{ route('auth.google.redirect') }}"
                    class="bg-mm-dark-blue text-white hover:bg-mm-border transition"
                />
            </div>
        </form>
    </div>
@endsection
