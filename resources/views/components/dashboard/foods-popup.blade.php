@props([
    "available_foods" => collect(),
])

@php
    $modal_id = "add-food-modal";
@endphp

<div
    id="{{ $modal_id }}"
    tabindex="-1"
    aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-101 w-full h-modal"
>
    <div class="relative p-4 w-full max-w-4xl h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
            <button
                type="button"
                class="absolute top-2 right-2 text-slate-400 hover:bg-slate-200 rounded p-1.5 dark:hover:bg-slate-700"
                data-modal-hide="{{ $modal_id }}"
            >
                <span class="sr-only">Close</span>
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="p-6 pt-10">
                <div class="flex items-end justify-between flex-wrap gap-4">
                    <div>
                        <h3
                            id="add-food-modal-title"
                            class="text-lg font-medium text-slate-900 dark:text-slate-100"
                        >
                            Add food
                        </h3>
                        <p
                            id="add-food-modal-subtitle"
                            class="text-sm text-slate-500 dark:text-slate-400 mt-1"
                        >
                            Click **Add** on the food you want to include. Edit
                            quantity before adding.
                        </p>
                    </div>

                    <x-mm-input
                        name="food-popup-search"
                        placeholder="Search food"
                    />
                </div>

                <form
                    id="add-food-form"
                    method="POST"
                    action="#"
                    class="hidden"
                >
                    @csrf
                    <input
                        type="hidden"
                        name="meal_code"
                        id="add-food-meal-code"
                        value=""
                    />
                    <input
                        type="hidden"
                        name="meal_type"
                        id="add-food-meal-type"
                        value=""
                    />
                    <input
                        type="hidden"
                        name="date"
                        id="add-food-date"
                        value=""
                    />
                    <input
                        type="hidden"
                        name="food_code"
                        id="add-food-food-code"
                        value=""
                    />
                    <input
                        type="hidden"
                        name="quantity"
                        id="add-food-quantity-hidden"
                        value=""
                    />
                    <input
                        type="hidden"
                        name="unit"
                        id="add-food-unit-hidden"
                        value=""
                    />
                </form>

                <div id="food-popup-grid" class="mt-4">
                    @include("components.dashboard.food-grid", ["available_foods" => $available_foods])
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce("scripts")
    <script>
        (function () {
            const input = document.getElementById('food-popup-search');
            const grid_wrapper = document.getElementById('food-popup-grid');
            if (!input || !grid_wrapper) return;

            const original_html = grid_wrapper.innerHTML;
            let timer = null;
            let controller = null;
            const MIN = 3;
            const DEBOUNCE = 300;

            function restore() {
                grid_wrapper.innerHTML = original_html;
            }

            async function doSearch(q) {
                if (controller) {
                    controller.abort();
                    controller = null;
                }

                if (!q || q.length < MIN) {
                    restore();
                    return;
                }

                controller = new AbortController();
                try {
                    grid_wrapper.innerHTML =
                        '<div class="text-sm text-slate-500 p-3">Searching…</div>';

                    const url = new URL(
                        '{{ route("foods.search") }}',
                        window.location.origin,
                    );
                    url.searchParams.set('q', q);

                    const res = await fetch(url.toString(), {
                        signal: controller.signal,
                    });
                    if (!res.ok) throw new Error('Search failed');

                    const payload = await res.json();
                    grid_wrapper.innerHTML = payload.html;
                } catch (err) {
                    if (err.name === 'AbortError') return;
                    console.error(err);
                    grid_wrapper.innerHTML =
                        '<div class="text-sm text-red-500 p-3">Search failed. Try again later.</div>';
                } finally {
                    controller = null;
                }
            }

            input.addEventListener('input', (e) => {
                clearTimeout(timer);
                const v = e.target.value.trim();
                timer = setTimeout(() => doSearch(v), DEBOUNCE);
            });
        })();

        /* Minimal JS: fill hidden form and submit when user clicks a .food-add-btn */
        (function () {
            const form = document.getElementById('add-food-form');
            const input_meal_code =
                document.getElementById('add-food-meal-code');
            const input_meal_type =
                document.getElementById('add-food-meal-type');
            const input_date = document.getElementById('add-food-date');
            const input_food_code =
                document.getElementById('add-food-food-code');
            const input_quantity = document.getElementById(
                'add-food-quantity-hidden',
            );
            const input_unit = document.getElementById('add-food-unit-hidden');

            function submitFoodAdd(food_code, qty, unit) {
                showGlobalLoader();

                const meal_code = input_meal_code.value || '';
                if (meal_code) {
                    form.action = `/meals/${encodeURIComponent(meal_code)}/foods`;
                } else {
                    form.action = `/meals`;
                }

                input_food_code.value = food_code;
                input_quantity.value = qty ?? 100;
                input_unit.value = unit ?? 'g';

                form.submit();
            }

            document.addEventListener('click', function (ev) {
                const btn = ev.target.closest('.food-add-btn');
                if (!btn) return;

                const food_code = btn.dataset.foodCode;
                const unit = btn.dataset.foodUnit || 'g';
                const qty_input = document.querySelector(
                    `[data-food-qty-input="${food_code}"]`,
                );
                const qty = qty_input ? qty_input.value : 100;

                const qty_val = Number(qty) || 0;
                if (qty_val <= 0) {
                    alert('Please enter a quantity greater than 0.');
                    return;
                }

                submitFoodAdd(food_code, qty_val, unit);
            });

            window.setAddFoodModalContext = function (
                meal_code,
                meal_type,
                date,
            ) {
                if (input_meal_code) input_meal_code.value = meal_code || '';
                if (input_meal_type) input_meal_type.value = meal_type || '';
                if (input_date) input_date.value = date || '';

                const title_el = document.getElementById(
                    'add-food-modal-title',
                );
                const sub_el = document.getElementById(
                    'add-food-modal-subtitle',
                );
                if (title_el)
                    title_el.textContent = meal_code
                        ? 'Add food to ' + meal_code
                        : 'Create new meal and add food';
                if (sub_el)
                    sub_el.textContent = meal_code
                        ? 'Select food and quantity to add to ' + meal_code
                        : 'Select food and quantity to create a new meal for the chosen date';
            };
        })();
    </script>
@endpushOnce
