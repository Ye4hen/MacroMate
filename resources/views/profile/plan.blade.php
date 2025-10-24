@extends("layouts.app")

@section("title", "Your plan")

@section("content")
    <h1 class="title">Your plan</h1>
    <form method="POST" action="{{ route("profile.update") }}">
        @csrf
        @method("PATCH")

        <x-mm-select
            label="Plan"
            name="plan_code"
            :options="$plans"
            :value="old('plan_code', $user->mu_plan_code)"
        />

        <div class="grid mt-5">
            <x-mm-button label="Save Changes" />
        </div>
    </form>
@endsection
