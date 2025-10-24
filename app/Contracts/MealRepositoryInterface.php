<?php

namespace App\Contracts;

use App\Domain\Models\Meal;

interface MealRepositoryInterface
{
    /** @return Meal[] */
    public function all(): array;
    public function paginate(bool $has_creator, bool $has_foods, int $per_page = 15, int $page = 1, ?string $creator = null, array $food_codes = [], ?string $day = null): \Illuminate\Pagination\LengthAwarePaginator;

    public function create(array $data): Meal;

    public function update(Meal $meal, array $data): Meal;

    public function delete(Meal $meal): bool;

    public function restore(Meal $meal): bool;
}
