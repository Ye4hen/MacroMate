@extends("layouts.app")

@section("title", "Your dashboard")

@section("content")
    <h1 class="title">Here is your dashboard</h1>
    @php
        $prev_date = $date->copy()->subDay();
        $next_date = $date->copy()->addDay();
        $today_string = now()->toDateString();
    @endphp

    <div class="flex items-center justify-center gap-x-3 my-4">
        <a
            href="{{ route("dashboard", ["date" => $prev_date->toDateString()]) }}"
            aria-label="Previous day"
            class="p-1 rounded hover:bg-mm-dark-blue"
        >
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h2 id="dashboard-date" class="font-medium">
            {{ $date->toDateString() }}
        </h2>

        <a
            href="{{ route("dashboard", ["date" => $next_date->toDateString()]) }}"
            aria-label="Next day"
            class="p-1 rounded hover:bg-mm-dark-blue"
        >
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <div class="flex items-end gap-x-5 overflow-auto mb-5">
        <x-charts.mm-chart-radial
            id="mm-chart-radial-calories"
            label="Calories"
            :series="[$todays_macros['eaten_calories_percent']]"
            :colors="['#F97316']"
            :stats='[
                "value" => $todays_macros["eaten_calories"],
                "full_value" => $todays_macros["calories"]
            ]'
        />
        <x-charts.mm-chart-radial
            id="mm-chart-radial-burned-calories"
            label="Burned calories"
            :series="[$todays_macros['burned_calories_percent']]"
            :colors="['#B91C1C']"
            :stats='[
                "value" => $todays_macros["burned_calories"],
                "full_value" => $todays_macros["eaten_calories"]
            ]'
        />
        <x-charts.mm-chart-radial
            id="mm-chart-radial-water"
            label="Water"
            :series="[$todays_macros['drunk_water_percent']]"
            :colors="['#D4F1F9']"
            :stats='[
                "value" => $todays_macros["drunk_water"],
                "full_value" => $todays_macros["water"]
            ]'
        />
        <x-charts.mm-chart-radial
            id="mm-chart-radial-proteins"
            label="Protein"
            :series="[$todays_macros['eaten_proteins_percent']]"
            :colors="['#4CAF50']"
            :stats='[
                "value" => $todays_macros["eaten_proteins"],
                "full_value" => $todays_macros["protein"]
            ]'
        />
        <x-charts.mm-chart-radial
            id="mm-chart-radial-fat"
            label="Fats"
            :series="[$todays_macros['eaten_fat_percent']]"
            :colors="['#FF9800']"
            :stats='[
                "value" => $todays_macros["eaten_fat"],
                "full_value" => $todays_macros["fat"]
            ]'
        />
        <x-charts.mm-chart-radial
            id="mm-chart-radial-carbs"
            label="Carbs"
            :series="[$todays_macros['eaten_carbs_percent']]"
            :colors="['#2196F3']"
            :stats='[
                "value" => $todays_macros["eaten_carbs"],
                "full_value" => $todays_macros["carbs"]
            ]'
        />
        <x-charts.mm-chart-radial
            id="mm-chart-radial-fiber"
            label="Fiber"
            :series="[$todays_macros['eaten_fiber_percent']]"
            :colors="['#86EFAC']"
            :stats='[
                "value" => $todays_macros["eaten_fiber"],
                "full_value" => $todays_macros["fiber"]
            ]'
        />
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="flex flex-col gap-y-2.5 bg-mm-card p-4 shadow rounded-xl">
            <h4>Add Meal 🍽</h4>
            <x-mm-button
                type="button"
                class="text-center w-full add-food-btn"
                data-modal-target="add-food-modal"
                data-modal-toggle="add-food-modal"
                data-meal-code="{{ $add_meal_code }}"
                data-meal-type="{{ $add_meal_type }}"
                data-date="{{ $date->toDateString() }}"
            >
                <i class="fa-solid fa-plus"></i>
            </x-mm-button>
        </div>
        <div class="flex flex-col gap-y-2.5 bg-mm-card p-4 shadow rounded-xl">
            <h4>Add Activity 🏃🏻</h4>
            <x-mm-button
                type="button"
                class="text-center w-full add-activity-btn"
                data-modal-target="add-activity-modal"
                data-modal-toggle="add-activity-modal"
                data-date="{{ $date }}"
            >
                <i class="fa-solid fa-plus"></i>
            </x-mm-button>
        </div>
    </div>

    <x-dashboard.meals-list
        class="mt-6"
        :grouped_meals="$meals"
        :date="$date"
    />
    <x-dashboard.todays-activities-list
        class="mt-6"
        :activities="$user_activities"
        :date="$date"
        :total-calories-burned="$todays_macros['burned_calories']"
    />
    <x-dashboard.activities-popup :activities="$activities" :date="$date" />
    @if ($has_meals)
        <x-dashboard.food-edit-popup />
    @endif

    @if (count($user_activities))
        <x-dashboard.activities-edit-popup :date="$date" />
    @endif

    <x-dashboard.foods-popup :available_foods="$foods" />
@endsection

@once
    @push("scripts")
        <script>
            // Foods Popup
            (function () {
                const add_food_form = document.getElementById('add-food-form');
                const add_food_meal_code =
                    document.getElementById('add-food-meal-code');
                const add_food_meal_type =
                    document.getElementById('add-food-meal-type');
                const add_food_date = document.getElementById('add-food-date');
                const qty_input = document.getElementById('add-food-quantity');

                function initAddFoodModal() {
                    document
                        .querySelectorAll('.add-food-btn')
                        .forEach((btn) => {
                            btn.addEventListener('click', () => {
                                const meal_code = btn.dataset.mealCode || '';
                                const meal_type = btn.dataset.mealType || '';
                                const date = btn.dataset.date || '';

                                if (meal_code) {
                                    add_food_form.action = `/meals/${encodeURIComponent(meal_code)}/foods`;
                                    add_food_meal_code.value = meal_code;
                                    add_food_meal_type.value = '';
                                    add_food_date.value = '';
                                } else {
                                    add_food_form.action = `/meals`;
                                    add_food_meal_code.value = '';
                                    add_food_meal_type.value = meal_type;
                                    add_food_date.value = date;
                                }

                                if (qty_input && !qty_input.value)
                                    qty_input.value = 100;
                            });
                        });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener(
                        'DOMContentLoaded',
                        initAddFoodModal,
                    );
                } else {
                    initAddFoodModal();
                }
            })();

            // Foods Edit Popup
            (function () {
                function initEditFoodModal() {
                    const edit_form = document.getElementById('edit-food-form');
                    const remove_form = document.getElementById(
                        'edit-food-remove-form',
                    );
                    const input_meal_code = document.getElementById(
                        'edit-food-meal-code',
                    );
                    const input_food_code = document.getElementById(
                        'edit-food-food-code',
                    );
                    const input_quantity =
                        document.getElementById('edit-food-quantity');
                    const remove_input_food_code = document.getElementById(
                        'remove-food-food-code',
                    );
                    const img_container =
                        document.getElementById('edit-food-thumb');
                    const name_el = document.getElementById('edit-food-name');
                    const cals_el = document.getElementById('edit-food-cals');

                    document
                        .querySelectorAll('.edit-food-btn')
                        .forEach((btn) => {
                            btn.addEventListener('click', () => {
                                const meal_code = btn.dataset.mealCode;
                                const food_code = btn.dataset.foodCode;
                                const food_name = btn.dataset.foodName || '';
                                const food_image = btn.dataset.foodImage || '';
                                const food_cals = btn.dataset.foodCals || '';
                                const food_qty =
                                    btn.dataset.foodQuantity || 100;

                                // Set visible fields
                                name_el.textContent = food_name;
                                cals_el.textContent = food_cals
                                    ? `${food_cals} kcal / 100g`
                                    : '';

                                // Thumbnail
                                if (food_image) {
                                    img_container.innerHTML = `<img src="${encodeURI(food_image)}" alt="${escapeHtml(food_name)}" class="w-16 h-16 rounded object-cover">`;
                                } else {
                                    img_container.innerHTML = `<div class="w-16 h-16 rounded bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-sm text-slate-500">N/A</div>`;
                                }

                                // Set inputs
                                input_meal_code.value = meal_code || '';
                                input_food_code.value = food_code || '';
                                input_quantity.value = food_qty;
                                remove_input_food_code.value = food_code || '';

                                if (edit_form) {
                                    edit_form.action = `/meals/${encodeURIComponent(meal_code)}/foods/${encodeURIComponent(food_code)}`;
                                }
                                if (remove_form) {
                                    remove_form.action = `/meals/${encodeURIComponent(meal_code)}/foods/${encodeURIComponent(food_code)}`;
                                }
                            });
                        });
                }

                // Helper to escape HTML
                function escapeHtml(str) {
                    return String(str).replace(/[&<>"']/g, function (s) {
                        return {
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#39;',
                        }[s];
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener(
                        'DOMContentLoaded',
                        initEditFoodModal,
                    );
                } else {
                    initEditFoodModal();
                }
            })();

            // Activities Edit Popup
            (function () {
                function initEditActivityModal() {
                    const edit_form =
                        document.getElementById('edit-activity-form');
                    const remove_form = document.getElementById(
                        'edit-activity-remove-form',
                    );
                    const input_activity_code = document.getElementById(
                        'edit-activity-activity-code',
                    );
                    const input_time_spent = document.getElementById(
                        'edit-activity-spent-time',
                    );
                    const remove_input_activity_code = document.getElementById(
                        'remove-activity-activity-code',
                    );
                    const name_el =
                        document.getElementById('edit-activity-name');
                    const cals_el =
                        document.getElementById('edit-activity-cals');

                    document
                        .querySelectorAll('.edit-activity-btn')
                        .forEach((btn) => {
                            btn.addEventListener('click', () => {
                                const activity_code = btn.dataset.activityCode;
                                const activity_name =
                                    btn.dataset.activityName || '';
                                const activity_cals =
                                    btn.dataset.activityCals || '';
                                const activity_time_spent =
                                    btn.dataset.activityTimeSpent || '';

                                // Set visible fields
                                name_el.textContent = activity_name;
                                cals_el.textContent = activity_cals
                                    ? `${activity_cals} kcal / hour`
                                    : '';

                                // Set inputs
                                input_activity_code.value = activity_code || '';
                                input_time_spent.value =
                                    activity_time_spent || 30;
                                remove_input_activity_code.value =
                                    activity_code || '';

                                if (edit_form) {
                                    edit_form.action = `/user/activities/${encodeURIComponent(activity_code)}`;
                                }
                                if (remove_form) {
                                    remove_form.action = `/user/activities/${encodeURIComponent(activity_code)}`;
                                }
                            });
                        });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener(
                        'DOMContentLoaded',
                        initEditActivityModal,
                    );
                } else {
                    initEditActivityModal();
                }
            })();
        </script>
    @endpush
@endonce
