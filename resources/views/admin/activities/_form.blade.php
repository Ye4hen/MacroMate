<!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->

<div class="grid grid-cols-1 gap-4">
    <x-mm-input
        name="name"
        id="name"
        label="Name"
        :value="old('name', $activity->ma_name ?? '')"
        placeholder="Enter activity name"
    />

    <x-mm-input
        name="cals"
        id="cals"
        label="Calories (burned per hour)"
        :value="old('cals', $activity->ma_cals ?? '')"
        placeholder="e.g. 250"
        type="number"
        min="0"
    />

    <div class="flex items-center gap-3 mt-4">
        <x-mm-button
            type="submit"
            variant="primary"
            :label="$submit_label ?? 'Save'"
        />
        <x-mm-button
            href="{{ route('admin.activities.index') }}"
            variant="secondary"
            label="Cancel"
        />
    </div>
</div>
