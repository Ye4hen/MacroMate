@php
    $variant = $variant ?? "primary";
    $type = $type ?? "submit";
    $href = $href ?? null;
    $label = $label ?? null;
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag();

    $base_classes = "inline-flex items-center justify-center cursor-pointer px-4 py-2 rounded transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-1";
    $variant_class = match ($variant) {
        "secondary" => "mm-btn--secondary",
        "accent" => "mm-btn--accent",
        "danger" => "mm-btn--danger",
        default => "mm-btn--primary",
    };

    $disabled_attr = $attributes->has("disabled");
    $disabled_class = $disabled_attr ? "mm-btn--disabled" : "";

    $user_class = $attributes->get("class") ?? "";

    $classes = trim("{$base_classes} {$variant_class} {$disabled_class} {$user_class}");
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->except("class")->merge(["class" => $classes]) }}
    >
        @if ($label)
            {{ $label }}
        @endif

        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->except("class")->merge(["class" => $classes]) }}
    >
        @if ($label)
            {{ $label }}
        @endif

        {{ $slot }}
    </button>
@endif
