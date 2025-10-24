<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Domain\Models\User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'code' => $this->mu_code,
            'name' => $this->mu_name,
            'email' => $this->mu_email,
            'role' => $this->whenLoaded('role', fn () => new UserRoleResource($this->role)),
            'age' => $this->mu_age,
            'height' => $this->mu_height,
            'weight' => $this->mu_weight,
            'gender' => $this->mu_gender,
            'settings' => $this->mu_settings,
            'plan' => $this->whenLoaded('plan', fn () => new PlanResource($this->plan)),
            'created_at' => $this->mu_created_at->toIso8601String(),
            'updated_at' => $this->mu_updated_at->toIso8601String(),
        ];
    }
}
