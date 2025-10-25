<!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->

@extends("layouts.app")

@section("title", "Create Activity")

@section("content")
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="title">Create Activity</h1>
            <x-mm-button
                href="{{ route('admin.activities.index') }}"
                variant="secondary"
                label="Back"
            />
        </div>

        <div
            class="bg-mm-card p-6 rounded-lg shadow-sm border border-mm-border"
        >
            <form
                action="{{ route("admin.activities.store") }}"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                @csrf

                @include(
                    "admin.activities._form",
                    [
                        "activity" => $activity,
                        "submit_label" => "Create activity",
                    ]
                )
            </form>
        </div>
    </div>
@endsection
