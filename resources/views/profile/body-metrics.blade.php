@extends("layouts.app")

@section("title", "Your body metrics")

@section("content")
    <h1 class="title">There are your body metrics, {{ $user->mu_name }}!</h1>
    <form method="POST" action="{{ route("profile.update") }}">
        @csrf
        @method("PATCH")

        <div class="gap-4 grid mb-4">
            <x-mm-input
                label="Weight (kg)"
                name="weight"
                type="number"
                error_name="mu_weight"
                value="{{ old('weight', $user->mu_weight) }}"
            />

            <x-mm-input
                label="Height (cm)"
                name="height"
                type="number"
                error_name="mu_height"
                value="{{ old('height', $user->mu_height) }}"
            />

            <x-mm-input
                label="Age"
                name="age"
                type="number"
                error_name="mu_age"
                value="{{ old('age', $user->mu_age) }}"
            />

            <x-mm-select
                label="Gender"
                name="gender"
                :options="['male' => 'Male', 'female' => 'Female']"
                value="{{ old('gender', $user->mu_gender) }}"
            />
        </div>

        <div class="grid space-y-2">
            <x-mm-button label="Save Changes" />
        </div>
    </form>
@endsection
