<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Domain\Models\Plan
 */
class PlanResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'code' => $this->mp_code,
            'name' => $this->mp_name,
            'calories_index' => (float)$this->mp_cal_index,
            'pfc' => $this->mp_pfc,
            'activities' => ActivityResource::collection(
                $this->whenLoaded('activities') ?? collect()
            ),
            'created_at' => $this->mp_created_at->toIso8601String(),
            'updated_at' => $this->mp_updated_at->toIso8601String(),
        ];
    }
}
