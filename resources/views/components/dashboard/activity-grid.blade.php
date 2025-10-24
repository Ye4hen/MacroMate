<!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
<div class="grid grid-cols-1 gap-3 max-h-[50vh] overflow-auto pr-2">
    @forelse($activities as $activity)
        <div
            class="activity-card bg-white dark:bg-slate-900 border rounded-lg p-3 flex items-center justify-between gap-3"
            data-activity-code="{{ $activity->ma_code }}" data-activity-cals="{{ $activity->ma_cals }}">
            <div>
                <div class="font-medium text-slate-800 dark:text-slate-100">{{ $activity->ma_name }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    {{ (int)$activity->ma_cals }} kcal / hr
                </div>
            </div>

            <div class="flex items-center gap-2">
                <x-mm-input type="number" name="time_{{ $activity->ma_code }}"
                            data-activity-time-input="{{ $activity->ma_code }}"
                            min="1" step="1" value="30" class="w-20 text-sm"/>
                <x-mm-button type="button" class="activity-add-btn inline-flex items-center px-3 py-1"
                             data-activity-code="{{ $activity->ma_code }}">
                    Add
                </x-mm-button>
            </div>
        </div>
    @empty
        <div class="text-sm text-slate-500">No activities found.</div>
    @endforelse
</div>
