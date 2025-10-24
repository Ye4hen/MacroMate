<?php

namespace App\Contracts;

use App\Domain\Models\Plan;

interface PlanRepositoryInterface
{
    /** @return Plan[] */
    public function all(): array;
    public function create(array $data): Plan;
    public function update(Plan $plan, array $data): Plan;
    public function delete(Plan $plan): bool;
    public function restore(Plan $plan): bool;
}
