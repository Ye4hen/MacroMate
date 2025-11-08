<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivity extends Model
{
    use SoftDeletes;

    protected $table = 'mm_user_activities';
    protected $primaryKey = 'mua_id';
    public $timestamps = true;
    public const CREATED_AT = 'mua_created_at';
    public const UPDATED_AT = 'mua_updated_at';
    public const DELETED_AT = 'mua_deleted_at';

    protected $fillable = ['mu_id', 'ma_id', 'mua_time', 'mua_calories_burned', 'mua_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mu_id', 'mu_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'ma_id', 'ma_id');
    }
}
