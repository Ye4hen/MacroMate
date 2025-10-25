@props(["grouped_meals" => [], "date" => null])
@php
    $grouped_meals = collect($grouped_meals);
    $date_string = $date ? $date->toDateString() : now()->toDateString();
@endphp

<div {{ $attributes->merge(["class" => "space-y-6"]) }}>
    @foreach ($grouped_meals as $type_label => $meals)
        <section
            class="bg-white dark:bg-slate-800 border rounded-lg shadow-sm overflow-hidden"
        >
            <header
                class="px-4 py-3 flex items-center justify-between border-b dark:border-slate-700"
            >
                <h3
                    class="text-lg font-semibold text-slate-800 dark:text-slate-100"
                >
                    {{ $type_label }}
                </h3>
            </header>
            <div class="p-4">
                @if ($meals->isEmpty())
                    <div class="text-sm text-slate-500 mb-4">
                        No meals for this type on this day.
                    </div>
                    <x-mm-button
                        type="button"
                        class="text-center w-full add-food-btn"
                        data-modal-target="add-food-modal"
                        data-modal-toggle="add-food-modal"
                        data-meal-code=""
                        data-meal-type="{{ $type_label }}"
                        data-date="{{ $date_string }}"
                    >
                        <i class="fa-solid fa-plus"></i>
                    </x-mm-button>
                @else
                    <div class="space-y-4">
                        @foreach ($meals as $meal)
                            @php
                                $nutrients = $meal->nutrients() ?? [];
                            @endphp

                            <x-mm-button
                                type="button"
                                class="text-center w-full add-food-btn"
                                data-modal-target="add-food-modal"
                                data-modal-toggle="add-food-modal"
                                data-meal-code="{{ $meal->getRouteKey() }}"
                                data-meal-type="{{ $type_label }}"
                                data-date="{{ $date_string }}"
                            >
                                <i class="fa-solid fa-plus"></i>
                            </x-mm-button>
                            <div
                                class="border rounded-md p-3 bg-slate-50 dark:bg-slate-900 dark:border-slate-700"
                            >
                                <div
                                    class="flex items-start justify-between gap-4"
                                >
                                    <div>
                                        <div
                                            class="flex items-center flex-wrap gap-y-1.5 gap-x-3 mt-2 text-sm text-slate-600 dark:text-slate-300"
                                        >
                                            <span>
                                                🔥
                                                {{ $nutrients["calories"] ?? 0 }}
                                                kcal
                                            </span>
                                            <span>
                                                P
                                                {{ $nutrients["proteins"] ?? 0 }}
                                                g
                                            </span>
                                            <span>
                                                F {{ $nutrients["fat"] ?? 0 }}
                                                g
                                            </span>
                                            <span>
                                                C
                                                {{ $nutrients["carbs"] ?? 0 }}
                                                g
                                            </span>
                                            <span>
                                                Fib
                                                {{ $nutrients["fiber"] ?? 0 }}
                                                g
                                            </span>
                                            <span>
                                                Water
                                                {{ $nutrients["water"] ?? 0 }}
                                                ml
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <ul
                                    class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2"
                                >
                                    @forelse ($meal->foods as $food)
                                        @php
                                            $name = $food->mf_name;
                                            $qty = $food->pivot->mmfr_quantity;
                                            $unit = $food->pivot->mmfr_unit;
                                        @endphp

                                        <li
                                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white dark:bg-slate-800 border rounded px-3 py-2"
                                        >
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <div class="text-sm">
                                                    <h4
                                                        class="font-medium text-slate-800 dark:text-slate-100"
                                                    >
                                                        {{ $name }}
                                                    </h4>
                                                    <div
                                                        class="text-xs text-slate-500 dark:text-slate-400"
                                                    >
                                                        {{ $qty . ($unit ? " " . $unit : "") }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="text-xs text-slate-500 dark:text-slate-400"
                                            >
                                                @if (isset($food->mf_cals))
                                                    {{ (float) $food->mf_cals }}
                                                    kcal/100g
                                                @endif
                                            </div>
                                            <div
                                                class="flex items-center gap-2"
                                            >
                                                <x-mm-button
                                                    type="button"
                                                    class="edit-food-btn inline-flex items-center px-2 py-1 rounded hover:bg-gray-100"
                                                    data-modal-target="edit-food-in-meal-modal"
                                                    data-modal-toggle="edit-food-in-meal-modal"
                                                    data-meal-code="{{ $meal->getRouteKey() }}"
                                                    data-food-code="{{ $food->mf_code }}"
                                                    data-food-name="{{ $food->mf_name }}"
                                                    data-food-image="{{ $food->getImageVariantUrl('webp', 300) }}"
                                                    data-food-cals="{{ $food->mf_cals }}"
                                                    data-food-quantity="{{ $food->pivot->mmfr_quantity }}"
                                                    title="Edit {{ $food->mf_name }}"
                                                >
                                                    <i
                                                        class="fa-regular fa-pen-to-square"
                                                    ></i>
                                                </x-mm-button>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-sm text-slate-500">
                                            No foods in this meal.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endforeach
</div>
