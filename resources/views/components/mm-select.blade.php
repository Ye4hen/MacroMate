@php
    $name = $name ?? "";
    $label = $label ?? "";
    $options = $options ?? [];
    $value = $value ?? null;
    $required = $required ?? false;
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag();

    $selected = $value ? $value : old($name);
    $errors = $errors ?? (session()->get("errors") ?? new \Illuminate\Support\ViewErrorBag());
@endphp

<div>
    <label
        for="{{ $name }}"
        class="block text-sm font-medium text-mm-light-gray mb-1"
    >
        {{ $label }}
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($required) required @endif
        {{
            $attributes->merge([
                "class" => "w-full border px-3 py-2 rounded border-mm-border bg-mm-dark-blue text-white focus:border-mm-orange focus:ring-1 focus:ring-mm-orange",
            ])
        }}
    >
        @if (! isset($slot) || ! trim($slot->toHtml()))
            @foreach ($options as $key => $text)
                <option
                    value="{{ $key }}"
                    @selected((string) $selected === (string) $key)
                >
                    {{ $text }}
                </option>
            @endforeach
        @else
            {!! $slot !!}
        @endif
    </select>

    @error($name)
        <div class="text-mm-error text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
