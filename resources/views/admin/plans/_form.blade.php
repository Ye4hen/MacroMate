<!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
@php
    $val = fn($key, $fallback = '') => old($key, $fallback);
    $pfc = data_get($plan, 'mp_pfc', []);
@endphp

<div class="grid grid-cols-1 gap-4">
    <x-mm-input name="name" id="name" label="Name" :value="old('name', $plan->mp_name ?? '')" placeholder="Enter plan name" />

    <x-mm-input name="calories_index" id="calories_index" label="Calories index" :value="old('calories_index', $plan->mp_cal_index ?? '')" placeholder="e.g. 1.5" type="number" inputmode="numeric" min="0" />

    <div class="mt-2 border-t border-mm-border pt-4">
        <h3 class="text-sm font-medium text-mm-light-gray mb-3">Macronutrients / other (in percents)</h3>

        <div class="grid grid-cols-2 gap-3">
            <x-mm-input name="proteins" id="proteins" label="Proteins %" :value="old('proteins', data_get($pfc, 'proteins', ''))" type="number"
                inputmode="numeric" step="1" min="0" />

            <x-mm-input name="fat" id="fat" label="Fat %" :value="old('fat', data_get($pfc, 'fat', ''))" type="number"
                inputmode="numeric" step="1" min="0" />

            <x-mm-input name="carbs" id="carbs" label="Carbs %" :value="old('carbs', data_get($pfc, 'carbs', ''))" type="number"
                inputmode="numeric" step="1" min="0" />

            <x-mm-input name="fiber" id="fiber" label="Fiber (g)" :value="old('fiber', data_get($pfc, 'fiber', ''))" type="number"
                inputmode="numeric" step="1" min="0" />

            <x-mm-input name="water" id="water" label="Water (ml)" :value="old('water', data_get($pfc, 'water', ''))" type="number"
                inputmode="numeric" step="1" min="0" />
        </div>
    </div>

    <div class="flex items-center gap-3 mt-4">
        <x-mm-button type="submit" variant="primary" :label="$submit_label ?? 'Save'" />
        <x-mm-button href="{{ route('admin.plans.index') }}" variant="secondary" label="Cancel" />
    </div>
</div>
