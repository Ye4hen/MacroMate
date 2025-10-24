<?php

namespace App\View\Components\dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TodaysActivitiesList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $date,
        public Collection $activities,
        public float $totalCaloriesBurned = 0.0,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.todays-activities-list');
    }
}
