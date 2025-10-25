<!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->

@extends("layouts.app")

@section("title", "Create Plan")

@section("content")
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="title">Create Plan</h1>
            <x-mm-button
                href="{{ route('admin.plans.index') }}"
                variant="secondary"
                label="Back"
            />
        </div>

        <div
            class="bg-mm-card p-6 rounded-lg shadow-sm border border-mm-border"
        >
            <form
                action="{{ route("admin.plans.store") }}"
                method="POST"
                novalidate
            >
                @csrf

                @include(
                    "admin.plans._form",
                    [
                        "plan" => $plan,
                        "submit_label" => "Create plan",
                    ]
                )
            </form>
        </div>
    </div>
@endsection
