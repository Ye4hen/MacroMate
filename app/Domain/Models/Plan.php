<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $table = 'mm_plans';
    protected $primaryKey = 'mp_id';
    public $incrementing = true;
    public $timestamps = true;

    public const CREATED_AT = 'mp_created_at';
    public const UPDATED_AT = 'mp_updated_at';
    public const DELETED_AT = 'mp_deleted_at';

    protected $fillable = [
        'mp_code',
        'mp_name',
        'mp_cal_index',
        'mp_pfc',
    ];

    protected $casts = [
        'mp_id' => 'integer',
        'mp_cal_index' => 'decimal:2',
        'mp_pfc' => AsArrayObject::class,
    ];

    public function getRouteKeyName(): string
    {
        return 'mp_code';
    }

    public function activities(): belongsToMany
    {
        return $this->belongsToMany(
            \App\Domain\Models\Activity::class,
            'mm_plans_activities_relations',
            'mpar_mp',
            'mpar_ma'
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(
            User::class,
            'mp_code',
            'mu_plan_code'
        );
    }
}
