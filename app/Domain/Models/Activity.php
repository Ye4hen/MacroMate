<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $table = 'mm_activities';
    protected $primaryKey = 'ma_id';
    public $incrementing = true;
    public $timestamps = true;

    public const CREATED_AT = 'ma_created_at';
    public const UPDATED_AT = 'ma_updated_at';
    public const DELETED_AT = 'ma_deleted_at';

    protected $fillable = [
        'ma_code',
        'ma_name',
        'ma_cals',
    ];

    protected $casts = [
        'ma_id' => 'integer',
        'ma_cals' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'ma_code';
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(
            Plan::class,
            'mm_plans_activities_relations',
            'mpar_ma',
            'mpar_mp',
        );
    }

    public function userActivities(): HasMany
    {
        return $this->hasMany(UserActivity::class, 'ma_id', 'ma_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (self $activity) {
            $activity->userActivities()->delete();
        });

        static::restored(function (self $activity) {
            UserActivity::withTrashed()
              ->where('ma_id', $activity->ma_id)
              ->restore();
        });

        static::forceDeleted(function (self $activity) {
            UserActivity::withTrashed()
              ->where('ma_id', $activity->ma_id)
              ->forceDelete();
        });
    }
}
