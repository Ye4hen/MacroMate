<!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->

<section
    {{
        $attributes->merge([
            "class" => "bg-white dark:bg-slate-800 border rounded-lg shadow-sm overflow-hidden",
        ])
    }}
>
    <header
        class="px-4 py-3 flex items-center justify-between border-b dark:border-slate-700"
    >
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
            Today's Activities
        </h3>
        <h5>Total calories burned - {{ $totalCaloriesBurned }}</h5>
    </header>

    <div class="grid gap-4 p-4">
        @if ($activities->isEmpty())
            <div class="text-sm text-slate-500">No activities in this day.</div>
            <x-mm-button
                type="button"
                class="text-center w-full add-activity-btn"
                data-modal-target="add-activity-modal"
                data-modal-toggle="add-activity-modal"
                data-date="{{ $date }}"
            >
                <i class="fa-solid fa-plus"></i>
            </x-mm-button>
        @else
            <x-mm-button
                type="button"
                class="text-center w-full add-activity-btn"
                data-modal-target="add-activity-modal"
                data-modal-toggle="add-activity-modal"
                data-date="{{ $date }}"
            >
                <i class="fa-solid fa-plus"></i>
            </x-mm-button>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach ($activities as $activity)
                    @php
                        $name = $activity->activity->ma_name;
                        $time_spent = $activity->mua_time;
                        $calories_burned = $activity->mua_calories_burned;
                    @endphp

                    <li
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white dark:bg-slate-800 border rounded px-3 py-2"
                    >
                        <div class="flex items-center gap-3">
                            <div class="text-sm">
                                <h4
                                    class="font-medium text-slate-800 dark:text-slate-100"
                                >
                                    {{ $name }}
                                </h4>
                                <div
                                    class="text-xs text-slate-500 dark:text-slate-400"
                                >
                                    Minutes spent {{ $time_spent }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            Calories burned - {{ $calories_burned }}
                        </div>
                        <div class="flex items-center gap-2">
                            <x-mm-button
                                type="button"
                                class="edit-activity-btn inline-flex items-center px-2 py-1 rounded hover:bg-gray-100"
                                data-modal-toggle="edit-activity-modal"
                                data-modal-target="edit-activity-modal"
                                data-activity-code="{{ $activity->activity->ma_code }}"
                                data-activity-name="{{ $name }}"
                                data-activity-cals="{{ $activity->activity->ma_cals }}"
                                data-activity-time-spent="{{ $time_spent }}"
                                title="Edit {{ $name }}"
                            >
                                <i class="fa-regular fa-pen-to-square"></i>
                            </x-mm-button>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
