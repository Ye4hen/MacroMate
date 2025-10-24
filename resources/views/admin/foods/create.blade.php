<!-- Simplicity is an acquired taste. - Katharine Gerould -->

@extends("layouts.app")

@section("title", "Create Food")

@section("content")
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="title">Create Food</h1>
            <x-mm-button
                href="{{ route('admin.foods.index') }}"
                variant="secondary"
                label="Back"
            />
        </div>

        <div
            class="bg-mm-card p-6 rounded-lg shadow-sm border border-mm-border"
        >
            <form
                action="{{ route("admin.foods.store") }}"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                @csrf

                @include(
                    "admin.foods._form",
                    [
                        "food" => $food,
                        "submit_label" => "Create food",
                    ]
                )
            </form>
        </div>
    </div>
@endsection
