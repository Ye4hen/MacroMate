<!-- Be present above all else. - Naval Ravikant -->

@extends("layouts.app")

@section("title", "Edit Food")

@section("content")
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="title">Edit Food</h1>
            <div class="flex items-center gap-2">
                <x-mm-button
                    href="{{ route('admin.foods.index') }}"
                    variant="secondary"
                    label="Back"
                />
            </div>
        </div>

        <div
            class="bg-mm-card p-6 rounded-lg shadow-sm border border-mm-border"
        >
            <form
                action="{{ route("admin.foods.update", $food) }}"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                @csrf
                @method("PATCH")

                @include(
                    "admin.foods._form",
                    [
                        "food" => $food,
                        "submit_label" => "Save changes",
                    ]
                )
            </form>

            <div class="mt-4">
                <form
                    action="{{ route("admin.foods.destroy", $food) }}"
                    method="POST"
                    onsubmit="return confirm('Delete this food?');"
                >
                    @csrf
                    @method("DELETE")
                    <x-mm-button
                        type="submit"
                        variant="danger"
                        label="Delete food"
                    />
                </form>
            </div>
        </div>
    </div>
@endsection
