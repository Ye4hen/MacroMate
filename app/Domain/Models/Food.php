<?php

namespace App\Domain\Models;

use App\Enums\FoodTypeEnum;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @property int                              $mf_cals
 * @property array<string,float>|\ArrayObject $mf_pfcfw
 * @property-read \Illuminate\Database\Eloquent\Relations\Pivot $pivot
 */
class Food extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'mm_foods';
    protected $primaryKey = 'mf_id';
    public $incrementing = true;
    public $timestamps = true;

    public const CREATED_AT = 'mf_created_at';
    public const UPDATED_AT = 'mf_updated_at';
    public const DELETED_AT = 'mf_deleted_at';

    protected $fillable = [
      'mf_code',
      'mf_name',
      'mf_type',
      'mf_image_url',
      'mf_image_disk',
      'mf_image_variants',
      'mf_cals',
      'mf_pfcfw',
      'mf_plan_code',
      'mf_created_by',
      'mf_updated_by',
    ];

    protected $casts = [
      'mf_id' => 'integer',
      'mf_type' => FoodTypeEnum::class,
      'mf_cals' => 'integer',
      'mf_pfcfw' => AsArrayObject::class,
      'mf_plan_code' => 'string',
      'mf_image_variants' => 'array',
    ];

    public function getImageUrlAttribute(string $value = '')
    {
        $image = !empty($value) ? $value : $this->mf_image_url;

        if (empty($image)) {
            return '';
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        $disk = $this->mf_image_disk ?? 'public';

        try {
            if (Storage::disk($disk)->exists($image)) {
                return Storage::disk($disk)->url($image);
            }
        } catch (\Throwable $e) {
        }

        return '';
    }

    public function getImageVariantUrl(string $format = 'webp', int $width = 300): string
    {
        $allowed_sizes = [480, 300, 150, 50];

        if (! in_array($width, $allowed_sizes, true)) {
            $width = 300;
        }

        $variants = $this->mf_image_variants ?? [];

        if (!empty($variants[$format]) && !empty($variants[$format][(string)$width])) {
            $path = $variants[$format][(string)$width];
            $disk = $this->mf_image_disk ?? config('filesystems.default', 'public');

            try {
                return Storage::disk($disk)->url($path);
            } catch (\Throwable $e) {
                return '';
            }
        }

        // fallback to thumbnail
        if (!empty($variants['thumbnail'])) {
            return $this->getImageUrlAttribute($variants['thumbnail']);
        }

        return $this->getImageUrlAttribute();
    }

    public function getRouteKeyName(): string
    {
        return 'mf_code';
    }

    public function isDrink(): bool
    {
        return $this->mf_type->value === 'drink';
    }

    public function recommendedForPlan(): BelongsTo
    {
        return $this->belongsTo(
            Plan::class,
            'mf_plan_code',
            'mp_code',
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'mf_created_by',
            'mu_code',
        );
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'mf_updated_by',
            'mu_code',
        );
    }

    public function meals()
    {
        return $this->belongsToMany(
            Meal::class,
            'mm_meals_foods_relations',
            'mmfr_mf',
            'mmfr_mm'
        )->withPivot(['mmfr_quantity', 'mmfr_unit']);
    }
}
