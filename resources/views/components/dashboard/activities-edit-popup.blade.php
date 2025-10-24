<!-- It is never too late to be what you might have been. - George Eliot -->

<div id="edit-activity-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-modal">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
            <button type="button"
                class="absolute top-3 right-2.5 text-slate-400 hover:bg-slate-200 rounded p-1.5 dark:hover:bg-slate-700"
                data-modal-hide="edit-activity-modal">
                <span class="sr-only">Close</span>
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="px-6 py-4">
                <h3 id="edit-activity-modal-title" class="text-lg font-medium text-slate-900 dark:text-slate-100">
                    Edit activity
                </h3>
                <p id="edit-activity-modal-subtitle" class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Adjust spent time or remove the activity from this day.
                </p>

                <div class="mt-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <div id="edit-activity-name" class="font-medium text-slate-800 dark:text-slate-100"></div>
                            <div id="edit-activity-cals" class="text-xs text-slate-500 dark:text-slate-400 mt-1"></div>

                            <form id="edit-activity-form" method="POST" action="#" class="mt-4 form-with-loader">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="activity_code" id="edit-activity-activity-code"
                                    value="">
                                <input type="hidden" name="date" id="edit-activity-date"
                                    value="{{ $date }}">

                                <div class="mt-3 grid grid-cols-2 gap-3">
                                    <x-mm-input id="edit-activity-spent-time" label="Spent time" name="time_spent"
                                        type="number" inputmode="numeric" pattern="[0-9]*"
                                        class="mt-1 block w-full rounded border px-3 py-2" required />
                                </div>

                                <div class="mt-4 flex items-center gap-2">
                                    <x-mm-button type="submit">Save</x-mm-button>
                                    <x-mm-button type="button" data-modal-hide="edit-activity-modal">
                                        Cancel
                                    </x-mm-button>
                                </div>
                            </form>

                            <form id="edit-activity-remove-form" method="POST" action="#" class="inline-block mt-2 form-with-loader"
                                onsubmit="return confirm('Remove this activity from this day?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="activity_code" id="remove-activity-activity-code"
                                    value="">
                                <input type="hidden" name="date" id="remove-activity-date"
                                    value="{{ $date }}">
                                <x-mm-button type="submit" variant="secondary">Remove</x-mm-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
