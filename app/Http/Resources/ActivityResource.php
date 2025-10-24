<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Domain\Models\Activity
 */
class ActivityResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'code' => $this->ma_code,
            'name' => $this->ma_name,
            'calories' => $this->ma_cals,
            'plans' => PlanResource::collection(
                $this->whenLoaded('plans') ?? collect()
            ),
            'created_at' => $this->ma_created_at->toIso8601String(),
            'updated_at' => $this->ma_updated_at->toIso8601String(),
        ];
    }
}
