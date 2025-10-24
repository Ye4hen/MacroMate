<?php

namespace App\Contracts;

use App\Domain\Models\Food;
use App\Enums\FoodTypeEnum;

interface FoodRepositoryInterface
{
    /** @return Food[] */
    public function all(): array;
    public function getCachedFoodsForTheList(): mixed;
    public function paginate(?FoodTypeEnum $type, int $per_page = 15, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator;
    public function create(array $data): Food;
    public function update(Food $food, array $data): Food;
    public function delete(Food $food): bool;
    public function restore(Food $food): bool;
}
