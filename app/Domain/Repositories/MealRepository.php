<?php

namespace App\Domain\Repositories;

use App\Contracts\MealRepositoryInterface;
use App\Domain\Models\Food;
use App\Domain\Models\Meal;
use App\Domain\Services\CodeGenerator;
use Illuminate\Pagination\LengthAwarePaginator;

class MealRepository implements MealRepositoryInterface
{
    public function __construct(private readonly CodeGenerator $codes)
    {
    }

    public function all(): array
    {
        $user = auth()->user();

        if (!$user instanceof \App\Domain\Models\User) {
            abort(403, 'Unauthorized user instance.');
        }

        return Meal::with(['creator', 'foods'])
          ->orderBy('mm_created_at', 'desc')
          ->get()
          ->all();
    }

    public function paginate(
        bool    $has_creator,
        bool    $has_foods,
        int     $per_page = 15,
        int     $page = 1,
        ?string $creator = null,
        array   $food_codes = [],
        ?string $day = null,
    ): LengthAwarePaginator {
        $with = [];

        if ($has_creator) {
            $with[] = 'creator';
        }

        if ($has_foods) {
            $with[] = 'foods';
        }

        $q = Meal::with($with);

        if ($creator) {
            $q->where('mm_user', $creator);
        }

        if ($day) {
            $q->whereDate('mm_date', $day);
        }

        if (count($food_codes)) {
            $q->whereHas('foods', fn ($sub) => $sub->whereIn('mf_code', $food_codes));
        }

        return $q->orderBy('mm_created_at', 'desc')
          ->paginate($per_page, ['*'], 'page', $page);
    }

    public function create(array $data): Meal
    {
        $items = $data['foods'] ?? [];
        unset($data['foods']);

        $meal = Meal::create($data);
        $meal->mm_code = $this->codes->generateCode();
        $meal->save();

        if (!empty($items)) {
            $sync = [];

            foreach ($items as $item) {
                $food = Food::where('mf_code', $item['code'])->first();

                if ($food) {
                    $sync[$food->mf_id] = [
                      'mmfr_quantity' => $item['quantity'],
                      'mmfr_unit' => $item['unit'],
                    ];
                }
            }
            $meal->foods()->sync($sync);
        }

        return $meal->load(['creator', 'foods']);
    }

    public function update(Meal $meal, array $data): Meal
    {
        $items = $data['foods'] ?? null;
        unset($data['foods']);

        $meal->fill($data)->save();

        if (is_array($items)) {
            $sync = [];

            foreach ($items as $item) {
                $food = Food::where('mf_code', $item['code'])->first();

                if ($food) {
                    $sync[$food->mf_id] = [
                      'mmfr_quantity' => $item['quantity'],
                      'mmfr_unit' => $item['unit'],
                    ];
                }
            }
            $meal->foods()->sync($sync);
        }

        return $meal->load(['creator', 'foods']);
    }

    public function delete(Meal $meal): bool
    {
        return $meal->delete();
    }

    public function restore(Meal $meal): bool
    {
        return $meal->restore();
    }
}
