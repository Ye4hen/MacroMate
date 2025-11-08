<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealFood extends Pivot
{
    use SoftDeletes;

    protected $table = 'mm_meals_foods_relations';

    public $incrementing = false;
    public $timestamps = false;

    public const DELETED_AT = 'mmfr_deleted_at';

    protected $fillable = ['mmfr_mm', 'mmfr_mf', 'mmfr_quantity', 'mmfr_unit'];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class, 'mmfr_mm', 'mm_id');
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class, 'mmfr_mf', 'mf_id');
    }
}
