<!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
@extends("layouts.app")

@section("title", "Admin Panel. Plans.")

@section("content")
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="title">Plans Admin</h1>

            <x-mm-button
                href="{{ route('admin.plans.create') }}"
                variant="accent"
                label="Add plan"
                class="shadow inline-flex items-center gap-2"
            />
        </div>

        <div
            class="overflow-x-auto relative border border-mm-border bg-mm-card shadow-sm rounded-lg"
        >
            <table class="w-full text-sm text-left">
                <thead
                    class="uppercase text-xs text-mm-light-gray"
                    style="background: rgba(255, 255, 255, 0.03)"
                >
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Calories index</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr class="border-t border-mm-border">
                            <td class="px-4 py-3 align-middle">
                                <div>
                                    <div class="font-medium text-white">
                                        {{ $plan->mp_name }}
                                    </div>
                                </div>
                            </td>

                            <td
                                class="px-4 py-3 align-middle text-mm-light-gray"
                            >
                                {{ $plan->mp_cal_index }}
                            </td>

                            <td class="px-4 py-3 align-middle">
                                <div class="flex items-center gap-2">
                                    <x-mm-button
                                        href="{{ route('admin.plans.edit', $plan->mp_code) }}"
                                        label="Edit"
                                        variant="secondary"
                                        class="px-3 py-1 text-sm"
                                    />

                                    <form
                                        method="POST"
                                        action="{{ route("admin.plans.destroy", $plan->mp_code) }}"
                                        onsubmit="return confirm('Delete this plan?');"
                                    >
                                        @csrf
                                        @method("DELETE")
                                        <x-mm-button
                                            type="submit"
                                            label="Delete"
                                            variant="danger"
                                            class="px-3 py-1 text-sm"
                                        />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if (! count($plans))
                        <tr>
                            <td
                                colspan="6"
                                class="px-4 py-6 text-center text-mm-light-gray"
                            >
                                No plans found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
