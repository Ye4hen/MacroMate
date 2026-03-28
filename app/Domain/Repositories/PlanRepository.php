<?php

namespace App\Domain\Repositories;

use App\Contracts\PlanRepositoryInterface;
use App\Domain\Models\Activity;
use App\Domain\Models\Plan;
use App\Domain\Services\CodeGenerator;

class PlanRepository implements PlanRepositoryInterface
{
    public function __construct(private readonly CodeGenerator $codes)
    {
    }

    public function all(): array
    {
        return Plan::with('activities')->get()->all();
    }

    public function create(array $data): Plan
    {
        $codes = $data['activity_codes'] ?? [];
        unset($data['activity_codes']);

        $plan = Plan::create($data);

        $activity_ids = Activity::whereIn('ma_code', $codes)
          ->pluck('ma_id')
          ->all();

        $plan->activities()->sync($activity_ids);

        $plan->mp_code = $this->codes->generateCode();
        $plan->save();

        return $plan->load('activities');
    }

    public function update(Plan $plan, array $data): Plan
    {
        $codes = $data['activity_codes'] ?? null;
        unset($data['activity_codes']);

        $plan->fill($data)->save();

        if (is_array($codes)) {
            $ids = Activity::whereIn('ma_code', $codes)
              ->pluck('ma_id')
              ->all();
            $plan->activities()->sync($ids);
        }

        return $plan->load('activities');
    }

    public function delete(Plan $plan): bool
    {
        return (bool)$plan->delete();
    }

    public function restore(Plan $plan): bool
    {
        return $plan->restore();
    }
}
