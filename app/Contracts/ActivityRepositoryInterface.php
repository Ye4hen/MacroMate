<?php

namespace App\Contracts;

use App\Domain\Models\Activity;

interface ActivityRepositoryInterface
{
    /** @return Activity[] */
    public function all(): array;
    public function getCachedActivities(): mixed;
    public function paginate(int $per_page = 15, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator;
    public function create(array $data): Activity;
    public function update(Activity $activity, array $data): Activity;
    public function delete(Activity $activity): bool;
    public function restore(Activity $activity): bool;
}
