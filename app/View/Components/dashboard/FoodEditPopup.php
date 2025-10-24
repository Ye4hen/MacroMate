<?php

namespace App\View\Components\dashboard;

use App\Domain\Models\Food;
use App\Domain\Models\Meal;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FoodEditPopup extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Meal $meal,
        public Food $food,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.food-edit-popup');
    }
}
