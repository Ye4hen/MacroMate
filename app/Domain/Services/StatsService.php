<?php

namespace App\Domain\Services;

use App\Domain\Models\Meal;
use App\Domain\Models\User;
use App\Domain\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class StatsService
{
    public function __construct(protected int $cache_ttl = 30)
    {
    }

    public function totalsForDate(string $user_code, Carbon $date, string $requested_field = 'all'): array
    {
        $date_string = Carbon::parse($date)->toDateString();

        $cache_key = $this->cacheKeyForDate($user_code, $date_string, $requested_field);

        return Cache::tags($this->cacheTagsForUser($user_code))
          ->remember(
              $cache_key,
              now()->addDays(7),
              fn () => $this->calculateTotalsForDate($user_code, $date_string, $requested_field)
          );
    }

    public function totalsForRange(string $user_code, Carbon|string $from, Carbon|string $to, string $requested_field = 'all', string $group_by = 'day'): array
    {
        $from = $from instanceof Carbon ? $from : Carbon::parse($from);
        $to = $to instanceof Carbon ? $to : Carbon::parse($to);

        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        $from_s = $from->toDateString();
        $to_s = $to->toDateString();

        $cache_key = $this->cacheKeyForRange($user_code, $from_s, $to_s, $requested_field, $group_by);

        return Cache::tags($this->cacheTagsForUser($user_code))
          ->remember(
              $cache_key,
              now()->addDays($this->cache_ttl),
              fn () => $this->calculateTotalsForRange($user_code, $from, $to, $from_s, $to_s, $requested_field, $group_by)
          );
    }

    protected function calculateTotalsForRange(
        string $user_code,
        Carbon|string $from,
        Carbon|string $to,
        Carbon|string $from_s,
        Carbon|string $to_s,
        string $requested_field = 'all',
        string $group_by = 'day'
    ): array {
        $cache_key = $this->cacheKeyForRange($user_code, $from_s, $to_s, $requested_field, $group_by);

        return Cache::tags($this->cacheTagsForUser($user_code))
          ->remember($cache_key, now()->addDays($this->cache_ttl), function () use ($user_code, $from, $to, $from_s, $to_s, $requested_field, $group_by) {
              $meals = Meal::with('foods')
                ->where('mm_user', $user_code)
                ->whereBetween('mm_date', [$from_s, $to_s])
                ->get();

              $meals_by_date = $meals->groupBy('mm_date');

              $activities_by_date = collect();
              $user_id = User::where('mu_code', $user_code)->value('mu_id');

              if ($user_id) {
                  $activities = UserActivity::where('mu_id', $user_id)
                      ->whereBetween('mua_date', [$from_s, $to_s])
                      ->selectRaw('DATE(mua_date) as day, SUM(mua_calories_burned) as sum_calories')
                      ->groupBy('day')
                      ->pluck('sum_calories', 'day');

                  $activities_by_date = $activities->mapWithKeys(
                      fn ($sum, $day) => [Carbon::parse($day)->toDateString() => (float)$sum]
                  );
              }

              $data = [];
              $cursor = $from->copy();

              while ($cursor->lte($to)) {
                  $date_key = $cursor->toDateString();

                  $meals_for_day = $meals_by_date->get($date_key, collect());

                  $totals = $this->returnRequestedField($requested_field, $meals_for_day);

                  if ($requested_field === 'all') {
                      $activities_cal = (float)$activities_by_date->get($date_key, 0.0);
                      $totals['activities_calories'] = round($activities_cal, 2);
                  }

                  $data[] = [
                    'date' => $date_key,
                    'totals' => $totals,
                  ];

                  $cursor->addDay();
              }

              return [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'group_by' => $group_by,
                'data' => $data,
              ];
          });
    }

    /**
     * Calculate totals for a single date. Uses a single DB query for meals/foods
     * and a single query for activities (per-day).
     */
    protected function calculateTotalsForDate(string $user_code, string $date_string, string $requested_field = 'all'): array|float
    {
        $meals = Meal::with('foods')
          ->where('mm_user', $user_code)
          ->whereDate('mm_date', $date_string)
          ->get();

        if ($requested_field !== 'all') {
            return $this->returnRequestedField($requested_field, $meals);
        }

        $meals_totals = $this->accumulateMealsTotals($meals);

        $user_id = User::where('mu_code', $user_code)->value('mu_id');
        $activities_calories = 0.0;

        if ($user_id) {
            $activities_calories = (float)UserActivity::where('mu_id', $user_id)
              ->whereDate('mua_date', $date_string)
              ->sum('mua_calories_burned');
        }

        $meals_totals['activities_calories'] = round($activities_calories, 2);

        return $meals_totals;
    }

    protected function accumulateMealsTotals(Collection $meals): array
    {
        $totals = [
          'calories' => 0.0,
          'proteins' => 0.0,
          'fat' => 0.0,
          'carbs' => 0.0,
          'fiber' => 0.0,
          'water' => 0.0,
        ];

        return $this->accumulateNutrientsTotals($totals, $meals);
    }

    protected function accumulateMealsTotalsCalories(Collection $meals): array|float
    {
        $totals = 0.0;

        return $this->accumulateNutrientsTotals($totals, $meals, 'calories');
    }

    protected function accumulateMealsTotalsProteins(Collection $meals): array|float
    {
        $totals = 0.0;

        return $this->accumulateNutrientsTotals($totals, $meals, 'proteins');
    }

    protected function accumulateMealsTotalsFat(Collection $meals): array|float
    {
        $totals = 0.0;

        return $this->accumulateNutrientsTotals($totals, $meals, 'fat');
    }

    protected function accumulateMealsTotalsCarbs(Collection $meals): array|float
    {
        $totals = 0.0;

        return $this->accumulateNutrientsTotals($totals, $meals, 'carbs');
    }

    private function accumulateNutrientsTotals(array|float $totals, Collection $meals, ?string $key = null): array|float
    {
        foreach ($meals as $meal) {
            $nutrients = $meal->nutrients();

            if (is_array($totals)) {
                foreach ($totals as $k => &$v) {
                    $v += $nutrients[$k] ?? 0;
                }
                unset($v);
            } else {
                $totals += $nutrients[$key];
            }
        }

        return is_array($totals) ? array_map(fn ($val) => is_float($val) ? round($val, 2) : $val, $totals) : round($totals, 2);
    }

    private function returnRequestedField(string $requested_field, Collection $meals): array|float
    {
        return match ($requested_field) {
            'calories' => $this->accumulateMealsTotalsCalories($meals),
            'proteins' => $this->accumulateMealsTotalsProteins($meals),
            'fat' => $this->accumulateMealsTotalsFat($meals),
            'carbs' => $this->accumulateMealsTotalsCarbs($meals),
            default => $this->accumulateMealsTotals($meals),
        };
    }

    private function cacheKeyForDate(string $user_code, string $date_string, string $requested_field): string
    {
        return "stats:daily:{$user_code}:{$date_string}:{$requested_field}";
    }

    private function cacheKeyForRange(string $user_code, string $from, string $to, string $requested_field, string $group_by): string
    {
        return "stats:range:{$user_code}:{$from}:{$to}:{$requested_field}:{$group_by}";
    }

    private function cacheTagsForUser(string $user_code): array
    {
        return ['stats', "user:{$user_code}"];
    }
}
