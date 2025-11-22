@props([
    "label" => "",
    "name" => "",
    "options" => [],
    "value" => null,
    "required" => false,
])

@php
    use Illuminate\Support\ViewErrorBag;
    $selected = $value ?? old($name);
    $errors = $errors ?? (session()->get("errors") ?? new ViewErrorBag());
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
        @if (! $slot?->isEmpty())
            {!! $slot !!}
        @else
            @foreach ($options as $key => $text)
                <option
                    value="{{ $key }}"
                    @selected((string) $selected === (string) $key)
                >
                    {{ $text }}
                </option>
            @endforeach
        @endif
    </select>

    @error($name)
        <div class="text-mm-error text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
