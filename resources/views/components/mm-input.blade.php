@php
    $name = $name ?? "";
    $id = $id ?? $name;
    $error_name = $error_name ?? null;
    $placeholder = $placeholder ?? null;
    $label = $label ?? "";
    $type = $type ?? "text";
    $value = $value ?? old($name);
    $required = $required ?? false;
    $autofocus = $autofocus ?? false;
    $label_tooltip = $label_tooltip ?? null;
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag();
    $errors = $errors ?? (session()->get("errors") ?? new \Illuminate\Support\ViewErrorBag());
    $popover_id = "label_popover_" . \Illuminate\Support\Str::random(8);

    if (empty($label_tooltip) && isset($attributes) && $attributes->has("label_tooltip")) {
        $label_tooltip = $attributes->get("label_tooltip");
        $attributes = $attributes->except("label_tooltip");
    }
@endphp

<div class="{{ $rootClasses }}">
    <label
        for="{{ $name }}"
        class="flex items-center text-sm font-medium text-mm-light-gray mb-1"
    >
        @if ($label)
            <span>{{ $label }}</span>
        @endif

        @if (! empty($label_tooltip))
            <button
                type="button"
                class="ms-2 inline-flex items-center justify-center rounded text-mm-light-gray hover:text-mm-orange focus:outline-none"
                data-popover-target="{{ $popover_id }}"
                data-popover-placement="bottom"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <i class="fa-solid fa-circle-info h-3"></i>
            </button>

            <div
                data-popover
                id="{{ $popover_id }}"
                role="tooltip"
                class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-64 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300"
            >
                <div class="p-3 space-y-2">
                    {!! $label_tooltip !!}
                </div>
                <div data-popper-arrow></div>
            </div>
        @endif
    </label>

    <div class="relative">
        <input
            id="{{ $id ?? $name }}"
            type="{{ $type }}"
            name="{{ $name }}"
            @if ($type !== 'file') value="{{ $value }}" @endif
            placeholder="{{ $placeholder ?? "Enter " . strtolower($label) }}"
            @if ($required) required @endif
            @if ($autofocus) autofocus @endif
            {{
                $attributes->merge([
                    "class" => "w-full border px-3 py-2 rounded border-mm-input bg-mm-dark-blue text-white focus:border-mm-orange",
                ])
            }}
        />

        @if ($type === "password")
            <button
                type="button"
                data-target="{{ $name }}"
                class="mm-toggle-password absolute right-2 top-1/2 -translate-y-1/2 p-1 rounded text-mm-light-gray hover:text-mm-orange focus:outline-none"
                aria-label="Toggle password visibility"
                aria-pressed="false"
            >
                <i class="fa-solid fa-eye mm-eye"></i>
                <i class="fa-solid fa-eye-slash !hidden mm-eye-off"></i>
            </button>
        @endif
    </div>

    @error($error_name ?? $name)
        <div class="text-mm-error text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

@once
    @push("scripts")
        <script>
            (function () {
                document.addEventListener(
                    'click',
                    function (ev) {
                        const btn =
                            ev.target.closest &&
                            ev.target.closest('.mm-toggle-password');
                        if (!btn) return;

                        ev.preventDefault();

                        const target_id = btn.getAttribute('data-target');
                        if (!target_id) return;

                        const input = document.getElementById(target_id);
                        if (!input) return;

                        const eye = btn.querySelector('.mm-eye');
                        const eye_off = btn.querySelector('.mm-eye-off');

                        const is_hidden = input.type === 'password';

                        if (is_hidden) {
                            input.type = 'text';
                            btn.setAttribute('aria-pressed', 'true');
                            if (eye) eye.classList.add('!hidden');
                            if (eye_off) eye_off.classList.remove('!hidden');
                        } else {
                            input.type = 'password';
                            btn.setAttribute('aria-pressed', 'false');
                            if (eye) eye.classList.remove('!hidden');
                            if (eye_off) eye_off.classList.add('!hidden');
                        }

                        input.focus({
                            preventScroll: true,
                        });
                    },
                    false,
                );
            })();
        </script>
    @endpush
@endonce
