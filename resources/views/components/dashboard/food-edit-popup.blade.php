<div id="edit-food-in-meal-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-101 w-full h-modal">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800"> <button type="button"
                class="absolute top-3 right-2.5 text-slate-400 hover:bg-slate-200 rounded p-1.5 dark:hover:bg-slate-700"
                data-modal-hide="edit-food-in-meal-modal"> <span class="sr-only">Close</span> <i
                    class="fa-solid fa-xmark"></i> </button>
            <div class="px-6 py-4">
                <h3 id="edit-food-modal-title" class="text-lg font-medium text-slate-900 dark:text-slate-100"> Edit food
                </h3>
                <p id="edit-food-modal-subtitle" class="text-sm text-slate-500 dark:text-slate-400 mt-1"> Adjust
                    quantity or remove the food from the meal. </p>
                <div class="mt-4">
                    <div class="flex items-start gap-4">
                        <div id="edit-food-thumb" class="flex-shrink-0">
                            <div
                                class="w-16 h-16 rounded bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-sm text-slate-500">
                                N/A </div>
                        </div>
                        <div class="flex-1">
                            <div id="edit-food-name" class="font-medium text-slate-800 dark:text-slate-100"></div>
                            <div id="edit-food-cals" class="text-xs text-slate-500 dark:text-slate-400 mt-1"></div>
                            <form id="edit-food-form" method="POST" action="#" class="mt-4 form-with-loader"> @csrf
                                @method('PATCH')
                                <input type="hidden" name="meal_code" id="edit-food-meal-code" value="">
                                <input type="hidden" name="food_code" id="edit-food-food-code" value="">
                                <div class="mt-3 grid grid-cols-2 gap-3"> <x-mm-input id="edit-food-quantity"
                                        label="Quantity" name="quantity" type="number" inputmode="numeric"
                                        pattern="[0-9]*" class="mt-1 block w-full rounded border px-3 py-2"
                                        value="100" required /> </div>
                                <div class="mt-4 flex items-center gap-2"> <x-mm-button
                                        type="submit">Save</x-mm-button> <x-mm-button type="button"
                                        data-modal-hide="edit-food-in-meal-modal"> Cancel </x-mm-button> </div>
                            </form>
                            <form id="edit-food-remove-form" method="POST" action="#"
                                class="inline-block mt-2 form-with-loader"
                                onsubmit="return confirm('Remove this food from the meal?');"> @csrf @method('DELETE')
                                <input type="hidden" name="food_code" id="remove-food-food-code" value="">
                                <x-mm-button type="submit" variant="secondary">Remove</x-mm-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
