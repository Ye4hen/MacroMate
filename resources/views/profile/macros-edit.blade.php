@extends("layouts.app")

@section("title", "Your Macros")

@section("content")
    <h1 class="title">{{ $user->mu_name }}, here are your macros!</h1>
    <h3 class="mb-6 text-lg">
        Plan:
        <span class="font-semibold">
            {{ $plan->mp_name ?? "No plan selected" }}
        </span>
    </h3>

    <form
        method="POST"
        action="{{ route("profile.macros.update") }}"
        class="grid gap-y-5"
    >
        @csrf
        @method("PATCH")

        <x-mm-input
            autocomplete="off"
            name="calories"
            label="Calories (kcal)"
            type="number"
            value="{{ $macros['calories'] }}"
        />
        <x-mm-input
            autocomplete="off"
            name="protein_percent"
            label="Protein (%)"
            type="number"
            value="{{ old('protein_percent', $macros['protein']['percent']) }}"
            label_tooltip="Max protein value is calculated based on your weight (weight in kg * 2.5)"
        />
        <x-mm-input
            autocomplete="off"
            name="fat_percent"
            label="Fat (%)"
            type="number"
            value="{{ old('fat_percent', $macros['fat']['percent']) }}"
        />
        <x-mm-input
            autocomplete="off"
            name="carbs_percent"
            label="Carbs (%)"
            type="number"
            value="{{ old('carbs_percent', $macros['carbs']['percent']) }}"
        />
        <x-mm-input
            autocomplete="off"
            name="fiber"
            label="Fiber (grams)"
            type="number"
            value="{{ old('fiber', $macros['fiber']) }}"
        />
        <x-mm-input
            autocomplete="off"
            name="water"
            label="Water (ml)"
            type="number"
            value="{{ old('water', $macros['water']) }}"
        />

        <div class="flex space-x-4 mt-6">
            <x-mm-button type="submit" label="Save" />
            <x-mm-button
                type="button"
                label="Cancel"
                href="{{ route('profile-macros') }}"
                variant="secondary"
            />
        </div>
    </form>
@endsection
