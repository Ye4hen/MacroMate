@php
    $val = fn ($key, $fallback = "") => old($key, $fallback);
    $pfc = data_get($food, "mf_pfcfw", []);
@endphp

<div class="grid grid-cols-1 gap-4">
    <x-mm-input
        name="name"
        id="name"
        label="Name"
        :value="old('mf_name', $food->mf_name ?? '')"
        placeholder="Enter food name"
    />
    @php
        $type_options = collect(\App\Enums\FoodTypeEnum::cases())
            ->mapWithKeys(
                fn ($case) => [
                    $case->value => \Illuminate\Support\Str::headline($case->name),
                ],
            )
            ->toArray();

        $selected_type = old("type", $food->mf_type instanceof \App\Enums\FoodTypeEnum ? $food->mf_type->value : $food->mf_type ?? "");
    @endphp

    <x-mm-select
        name="type"
        label="Type"
        :options="$type_options"
        :value="$selected_type"
        required
    />

    <x-mm-input
        name="image"
        id="image"
        label="Image"
        type="file"
        accept="image/*"
    />

    <div class="mt-3 flex items-start space-x-4">
        @if (! empty($food->mf_image_url))
            <div>
                <label
                    class="text-sm font-medium text-mm-light-gray mb-1 block"
                >
                    Current
                </label>
                <img
                    id="current-image-preview"
                    src="{{ $food->getImageVariantUrl("webp", 150) }}"
                    alt="Current image"
                    class="w-28 h-28 rounded border border-mm-border"
                />
            </div>
        @endif

        <div id="new-image-wrapper" style="display: none">
            <label class="text-sm font-medium text-mm-light-gray mb-1 block">
                Selected
            </label>
            <img
                id="new-image-preview"
                src="#"
                alt="Selected image"
                class="w-28 h-28 object-cover rounded border border-mm-border"
            />
        </div>
    </div>

    <x-mm-input
        name="cals"
        id="cals"
        label="Calories (per 100g)"
        :value="old('mf_cals', $food->mf_cals ?? '')"
        placeholder="e.g. 250"
        type="number"
        inputmode="numeric"
        min="0"
    />

    <div class="mt-2 border-t border-mm-border pt-4">
        <h3 class="text-sm font-medium text-mm-light-gray mb-3">
            Macronutrients / other (per 100g)
        </h3>

        <div class="grid grid-cols-2 gap-3">
            <x-mm-input
                name="proteins"
                id="proteins"
                label="Proteins (g)"
                :value="old('proteins', data_get($pfc, 'proteins', ''))"
                type="number"
                step="0.1"
                min="0"
            />

            <x-mm-input
                name="fat"
                id="fat"
                label="Fat (g)"
                :value="old('fat', data_get($pfc, 'fat', ''))"
                type="number"
                step="0.1"
                min="0"
            />

            <x-mm-input
                name="carbs"
                id="carbs"
                label="Carbs (g)"
                :value="old('carbs', data_get($pfc, 'carbs', ''))"
                type="number"
                step="0.1"
                min="0"
            />

            <x-mm-input
                name="fiber"
                id="fiber"
                label="Fiber (g)"
                :value="old('fiber', data_get($pfc, 'fiber', ''))"
                type="number"
                step="0.1"
                min="0"
            />

            <x-mm-input
                name="water"
                id="water"
                label="Water (%)"
                :value="old('water', data_get($pfc, 'water', ''))"
                type="number"
                step="0.1"
                min="0"
            />
        </div>
    </div>

    <div class="flex items-center gap-3 mt-4">
        <x-mm-button
            type="submit"
            variant="primary"
            :label="$submit_label ?? 'Save'"
        />
        <x-mm-button
            href="{{ route('admin.foods.index') }}"
            variant="secondary"
            label="Cancel"
        />
    </div>
</div>

@pushOnce("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('image');
            const new_wrapper = document.getElementById('new-image-wrapper');
            const new_preview = document.getElementById('new-image-preview');
            const current_preview = document.getElementById(
                'current-image-preview',
            );

            if (!input) return;

            input.addEventListener('change', function (ev) {
                const file = input.files?.[0];
                if (current_preview?.src) {
                    const url = URL.createObjectURL(file);
                    current_preview.src = url;
                    current_preview.style.display = '';
                    current_preview.onload = () => URL.revokeObjectURL(url);
                    return;
                }
                if (!file) {
                    new_wrapper.style.display = 'none';
                    new_preview.src = '#';
                    return;
                }

                const url = URL.createObjectURL(file);
                new_preview.src = url;
                new_wrapper.style.display = '';
                new_preview.onload = () => URL.revokeObjectURL(url);
            });
        });
    </script>
@endpushOnce
