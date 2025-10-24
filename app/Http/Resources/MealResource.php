<?php

namespace App\Http\Resources;

use App\Domain\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Domain\Models\Meal
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domain\Models\Food> $foods
 * @property-read \Illuminate\Support\Carbon $mm_created_at
 * @property-read \Illuminate\Support\Carbon $mm_updated_at
 */
class MealResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'code' => $this->mm_code,
            'type' => $this->mm_type,
            'order' => $this->mm_order,
            'date' => $this->mm_date,
            'creator' => $this->whenLoaded('creator', fn () => new UserResource($this->creator)),
            'foods' => $this->whenLoaded('foods', function () {
                /** @var \Illuminate\Database\Eloquent\Collection<int, Food> $foods */
                $foods = $this->foods;

                return $foods->map(function (Food $food): array {
                    /** @var object{mmfr_quantity: mixed, mmfr_unit: mixed} $pivot */
                    $pivot = $food->pivot;

                    return [
                        'code' => $food->mf_code,
                        'name' => $food->mf_name,
                        'quantity' => $pivot->mmfr_quantity,
                        'unit' => $pivot->mmfr_unit,
                    ];
                })->values()->all();
            }),
            'nutrients' => $this->whenLoaded('foods', fn () => $this->nutrients()),
            'created_at' => $this->mm_created_at->toIso8601String(),
            'updated_at' => $this->mm_updated_at->toIso8601String(),
        ];
    }
}
