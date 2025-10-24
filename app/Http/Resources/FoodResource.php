<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Domain\Models\Food
 *
 * @property-read \App\Domain\Models\Plan|null $plan
 * @property-read \Illuminate\Support\Carbon $mf_created_at
 * @property-read \Illuminate\Support\Carbon $mf_updated_at
 */
class FoodResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'code' => $this->mf_code,
            'name' => $this->mf_name,
            'type' => $this->mf_type,
            'image_url' => $this->mf_image_url,
            'calories' => $this->mf_cals,
            'pfcfw' => $this->mf_pfcfw,
            'plan' => $this->whenLoaded('plan', fn () => new PlanResource($this->plan)),
            'created_at' => $this->mf_created_at->toIso8601String(),
            'updated_at' => $this->mf_updated_at->toIso8601String(),
        ];
    }
}
