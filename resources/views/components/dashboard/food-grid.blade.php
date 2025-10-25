<!-- Nothing worth having comes easy. - Theodore Roosevelt -->

@php
    const PER_PAGE = 30;
    $is_last = $available_foods->count() < PER_PAGE;
@endphp

<div
    id="food-grid"
    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[55vh] overflow-auto pr-2"
>
    @include("components.dashboard.food-cards", ["foods" => $available_foods, "page" => 1, "is_last" => $is_last])
</div>
