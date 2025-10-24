<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FoodCards extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $foods,
        public int $page,
        public bool $is_last,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.food-cards');
    }
}
