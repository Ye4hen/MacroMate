<?php

namespace App\Domain\Repositories;

use App\Contracts\ActivityRepositoryInterface;
use App\Domain\Models\Activity;
use App\Domain\Models\Plan;
use App\Domain\Services\CodeGenerator;
use Illuminate\Support\Facades\Cache;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function __construct(private CodeGenerator $codes)
    {
    }

    public function all(): array
    {
        return Activity::with('plans')->get()->all();
    }

    public function getCachedActivities(): mixed
    {
        return Cache::tags(['catalogs'])
          ->remember('catalog:activities', now()->addHours(24), function () {
              return Activity::orderBy('ma_name')->limit(30)->get();
          });
    }

    public function paginate(int $per_page = 15, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Activity::with('plans')
          ->paginate($per_page, ['*'], 'page', $page);
    }

    public function create(array $data): Activity
    {
        $codes = $data['plans_codes'] ?? [];
        unset($data['plans_codes']);

        $activity = Activity::create($data);

        $plans_ids = Plan::whereIn('mp_code', $codes)
          ->pluck('mp_id')
          ->all();

        $activity->plans()->sync($plans_ids);

        $activity->ma_code = $this->codes->generateCode($activity->ma_id);
        $activity->save();

        $this->clearCache();

        return $activity->load('plans');
    }

    public function update(Activity $activity, array $data): Activity
    {
        $codes = $data['plans_codes'] ?? [];
        unset($data['plans_codes']);

        $activity->fill($data)->save();

        if (is_array($codes)) {
            $ids = Plan::whereIn('mp_code', $codes)
              ->pluck('mp_id')
              ->all();
            $activity->plans()->sync($ids);
        }

        $this->clearCache();

        return $activity->load('plans');
    }

    public function delete(Activity $activity): bool
    {
        $result = (bool)$activity->delete();

        if ($result) {
            $this->clearCache();
        }

        return $result;
    }

    public function restore(Activity $activity): bool
    {
        $result = $activity->restore();

        if ($result) {
            $this->clearCache();
        }

        return $result;
    }

    private function clearCache(): void
    {
        Cache::tags(['stats'])->flush();
        Cache::tags(['catalogs'])->forget('catalog:activities');
    }
}
