<?php

namespace App\View\Components\dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FoodGrid extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array|Collection $available_foods = [],
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.food-grid');
    }
}
