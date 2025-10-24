<?php

namespace App\Domain\Models;

use App\Enums\MealTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use SoftDeletes;

    protected $table = 'mm_meals';
    protected $primaryKey = 'mm_id';
    public $incrementing = true;
    public $timestamps = true;

    public const CREATED_AT = 'mm_created_at';
    public const UPDATED_AT = 'mm_updated_at';
    public const DELETED_AT = 'mm_deleted_at';

    protected $fillable = [
        'mm_code',
        'mm_type',
        'mm_user',
        'mm_order',
        'mm_date',
    ];

    protected $casts = [
        'mm_id' => 'integer',
        'mm_order' => 'integer',
        'mm_type' => MealTypeEnum::class,
    ];

    public function getRouteKeyName(): string
    {
        return 'mm_code';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'mm_user',
            'mu_code',
        );
    }

    public function getType(): MealTypeEnum
    {
        return $this->mm_type;
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(
            Food::class,
            'mm_meals_foods_relations',
            'mmfr_mm',
            'mmfr_mf'
        )->withPivot(['mmfr_quantity', 'mmfr_unit']);
    }

    public function nutrients(): array
    {
        $this->loadMissing('foods');

        $totals = [
            'proteins' => 0.0,
            'fat' => 0.0,
            'carbs' => 0.0,
            'fiber' => 0.0,
            'water' => 0.0,
            'calories' => 0.0,
        ];

        /** @var \App\Domain\Models\Food $food */
        foreach ($this->foods as $food) {
            /** @var \Illuminate\Database\Eloquent\Relations\Pivot $pivot */
            $pivot = $food->pivot;

            $qty = (float) ($pivot->mmfr_quantity ?? 0) / 100;

            $pfcfw = $food->mf_pfcfw;

            $totals['proteins'] += round(($pfcfw['proteins'] ?? 0) * $qty, 2);
            $totals['fat'] += round(($pfcfw['fat'] ?? 0) * $qty, 2);
            $totals['carbs'] += round(($pfcfw['carbs'] ?? 0) * $qty, 2);
            $totals['fiber'] += round(($pfcfw['fiber'] ?? 0) * $qty, 2);
            $totals['water'] += round(($pfcfw['water'] ?? 0) * $qty, 2);

            $totals['calories'] += round((float)$food->mf_cals * $qty, 2);
        }

        return $totals;
    }
}
