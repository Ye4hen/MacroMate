<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Domain\Models\UserRole
 */
class UserRoleResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'code' => $this->mur_code,
            'name' => $this->mur_name,
            'created_at' => $this->mur_created_at->toIso8601String(),
            'updated_at' => $this->mur_updated_at->toIso8601String(),
        ];
    }
}
