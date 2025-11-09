<?php

namespace App\Domain\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'mm_users';
    protected $primaryKey = 'mu_id';
    public $incrementing = true;
    public $timestamps = true;

    public const CREATED_AT = 'mu_created_at';
    public const UPDATED_AT = 'mu_updated_at';
    public const DELETED_AT = 'mu_deleted_at';

    protected $fillable = [
        'mu_code',
        'mu_name',
        'mu_email',
        'mu_password',
        'mu_role',
        'mu_age',
        'mu_height',
        'mu_weight',
        'mu_gender',
        'mu_settings',
        'mu_plan_code',
    ];

    protected $casts = [
        'mu_id' => 'integer',
        'mu_age' => 'integer',
        'mu_height' => 'integer',
        'mu_weight' => 'integer',
        'mu_gender' => 'string',
        'mu_plan_code' => 'string',
        'mu_settings' => AsArrayObject::class,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'mu_password',
    ];

    public function getRouteKeyName(): string
    {
        return 'mu_code';
    }

    public function getUserCode(): string
    {
        return $this->mu_code;
    }

    public function getAuthPassword(): string
    {
        return $this->mu_password;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isAdmin(): bool
    {
        return $this->mu_role === 'admin';
    }

    public function isSubAdmin(): bool
    {
        return $this->mu_role === 'sub_admin';
    }

    public function isPremium(): bool
    {
        return $this->mu_role === 'premium_user';
    }

    public function isPlainUser(): bool
    {
        return $this->mu_role === 'user';
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'mu_role', 'mur_code');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(
            Plan::class,
            'mu_plan_code',
            'mp_code',
        );
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class, 'mu_id', 'mu_id');
    }
}
