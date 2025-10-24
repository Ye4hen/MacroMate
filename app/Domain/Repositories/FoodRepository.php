<?php

namespace App\Domain\Repositories;

use App\Contracts\FoodRepositoryInterface;
use App\Domain\Models\Food;
use App\Domain\Services\CodeGenerator;
use App\Enums\FoodTypeEnum;
use Illuminate\Support\Facades\Cache;

class FoodRepository implements FoodRepositoryInterface
{
    public function __construct(private readonly CodeGenerator $codes)
    {
    }

    public function all(): array
    {
        return Food::with('creator')->get()->all();
    }

    public function getCachedFoodsForTheList(): mixed
    {
        return Cache::tags(['catalogs'])
          ->remember('catalog:foods', now()->addHours(24), function () {
              return Food::select('mf_code', 'mf_name', 'mf_type', 'mf_cals', 'mf_image_url', 'mf_image_disk', 'mf_image_variants')
                ->orderBy('mf_name')
                ->limit(30)
                ->get();
          });
    }

    public function paginate(?FoodTypeEnum $type, int $per_page = 15, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator
    {
        $food = Food::with('creator');

        if ($type) {
            $food = $food->where('mf_type', $type);
        }

        return $food->paginate($per_page, ['*'], 'page', $page);
    }

    public function create(array $data): Food
    {
        $food = Food::create($data);

        $food->mf_code = $this->codes->generateCode($food->mf_id);
        $food->save();

        return $food->load('creator');
    }

    public function update(Food $food, array $data): Food
    {
        $food->fill($data)->save();

        return $food->load(['creator', 'updater']);
    }

    public function delete(Food $food): bool
    {
        return (bool)$food->delete();
    }

    public function restore(Food $food): bool
    {
        return $food->restore();
    }
}
