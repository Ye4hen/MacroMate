<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'mm_user_roles';
    protected $primaryKey = 'mur_id';
    public $incrementing = true;
    public $timestamps = true;

    public const CREATED_AT = 'mur_created_at';
    public const UPDATED_AT = 'mur_updated_at';
    public const DELETED_AT = 'mur_deleted_at';

    protected $fillable = [
        'mur_code',
        'mur_name',
    ];

    protected $casts = [
        'mur_id' => 'integer',
    ];
    public function getRouteKeyName(): string
    {
        return 'mur_code';
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'mu_role', 'mur_code');
    }
}
