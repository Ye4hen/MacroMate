<?php

namespace App\Http\Controllers\Web;

use App\Contracts\ActivityRepositoryInterface;
use App\Contracts\FoodRepositoryInterface;
use App\Domain\Models\Meal;
use App\Domain\Services\MacrosService;
use App\Domain\Services\StatsService;
use App\Enums\MealTypeEnum;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct(
        private readonly StatsService $stats_service,
        private readonly FoodRepositoryInterface $foods_repository,
        private readonly ActivityRepositoryInterface $activities_repository,
        private readonly MacrosService $macros_service,
    ) {
    }

    public function index(Request $request): View|Application
    {
        $date_param = $request->query('date');
        $date = $date_param ? Carbon::parse($date_param) : now();

        $todays_macros = $this->calculateTodaysMacros($request, $date);
        $meals = $this->getMeals($request, $date);
        $has_meals = array_sum(array_map('count', $meals)) > 0;
        $foods = $this->foods_repository->getCachedFoodsForTheList();
        $activities = $this->activities_repository->getCachedActivities();
        $user_activities = $this->getCachedUserActivitiesForDate($request, $date->toDateString());

        $time_ref = $date->isToday() ? Carbon::now() : Carbon::parse($date->toDateString() . ' ' . Carbon::now()->format('H:i'));
        [$add_meal_type, $add_meal_code] = $this->computeAddMealTypeAndCode($meals, $time_ref);

        return view('dashboard.index', compact('todays_macros', 'date', 'meals', 'has_meals', 'add_meal_code', 'add_meal_type', 'foods', 'activities', 'user_activities'));
    }

    private function calculateTodaysMacros(Request $request, Carbon $date): array
    {
        $user = $request->user();

        $macros = $this->macros_service->calculateDailyMacrosForUser($user);

        $payload = $this->stats_service->totalsForDate($user->mu_code, $date);

        $calories = $macros['calories'];
        $proteins_grams = $macros['protein']['grams'];
        $fat_grams = $macros['fat']['grams'];
        $carbs_grams = $macros['carbs']['grams'];
        $water = $macros['water'];
        $fiber = $macros['fiber'];

        $eaten_calories_percent = (int) round(($payload['calories'] / max($calories, 1)) * 100);
        $eaten_proteins_percent = (int) round(($payload['proteins'] / max($proteins_grams, 1)) * 100);
        $eaten_fat_percent = (int) round(($payload['fat'] / max($fat_grams, 1)) * 100);
        $eaten_carbs_percent = (int) round(($payload['carbs'] / max($carbs_grams, 1)) * 100);
        $drunk_water_percent = (int) round(($payload['water'] / max($water, 1)) * 100);
        $eaten_fiber_percent = (int) round(($payload['fiber'] / max($fiber, 1)) * 100);
        $burned_calories = $payload['activities_calories'];
        $burned_calories_percent = (int) round(($burned_calories / max($payload['calories'], 1)) * 100);

        return [
          'eaten_calories_percent' => $eaten_calories_percent,
          'burned_calories_percent' => $burned_calories_percent,
          'eaten_calories' => $payload['calories'],
          'calories' => $calories,
          'eaten_proteins_percent' => $eaten_proteins_percent,
          'eaten_proteins' => $payload['proteins'],
          'protein' => $proteins_grams,
          'eaten_fat_percent' => $eaten_fat_percent,
          'eaten_fat' => $payload['fat'],
          'fat' => $fat_grams,
          'eaten_carbs_percent' => $eaten_carbs_percent,
          'eaten_carbs' => $payload['carbs'],
          'carbs' => $carbs_grams,
          'eaten_fiber_percent' => $eaten_fiber_percent,
          'eaten_fiber' => $payload['fiber'],
          'fiber' => $fiber,
          'drunk_water_percent' => $drunk_water_percent,
          'drunk_water' => $payload['water'],
          'water' => $water,
          'burned_calories' => $burned_calories,
        ];
    }

    private function getCachedUserActivitiesForDate(Request $request, string $date_string): mixed
    {
        $user = $request->user();
        $cache_key = "user_activities:{$user->mu_code}:{$date_string}";

        $result = Cache::tags(['stats', "user:{$user->mu_code}"])
          ->remember($cache_key, now()->addDays(7), function () use ($user, $date_string) {
              return $user->activities()->with('activity')->whereDate('mua_date', $date_string)->get();
          });

        return $result;
    }

    private function getMeals(Request $request, Carbon $date): array
    {
        $user = $request->user();
        $date_string = $date->toDateString();
        $meals = Meal::with(['foods'])
          ->where('mm_user', $user->mu_code)
          ->whereDate('mm_date', $date_string)
          ->orderBy('mm_order')
          ->get()
          ->filter(fn ($meal) => $meal->foods->isNotEmpty());

        $meal_type_labels = collect(MealTypeEnum::cases())->map(fn ($c) => $c->value);

        $grouped_meals = [];

        foreach ($meal_type_labels as $label) {
            $grouped_meals[$label] = $meals->filter(function ($meal) use ($label) {
                return $meal->mm_type->value === $label;
            })->values();
        }

        foreach ($grouped_meals as $key => $meals_of_type) {
            $grouped_meals[$key] = $meals_of_type;
        }

        return $grouped_meals;
    }

    private function pickMealTypeForTime(Carbon $time): string
    {
        $hour = (int)$time->format('H');
        $minute = (int)$time->format('i');
        $minutes = $hour * 60 + $minute;

        $windows = [
          MealTypeEnum::BREAKFAST->value => [0, 10 * 60 + 30],        // 00:00 - 10:30
          MealTypeEnum::MIDMORNING_SNACK->value => [10 * 60 + 30, 12 * 60],  // 10:30 - 12:00
          MealTypeEnum::LUNCH->value => [12 * 60, 14 * 60 + 30],  // 12:00 - 14:30
          MealTypeEnum::AFTERNOON_SNACK->value => [14 * 60 + 30, 17 * 60],  // 14:30 - 17:00
          MealTypeEnum::DINNER->value => [17 * 60, 20 * 60],       // 17:00 - 20:00
          MealTypeEnum::LATE_DINNER->value => [20 * 60, 23 * 60 + 59],  // 20:00 - 23:59
        ];

        foreach ($windows as $label => [$start, $end]) {
            if ($minutes >= $start && $minutes < $end) {
                return $label;
            }
        }

        return MealTypeEnum::LATE_DINNER->value;
    }

    private function computeAddMealTypeAndCode(array $meals, Carbon $time): array
    {
        $meal_type = $this->pickMealTypeForTime($time);

        $meal_code = '';

        if (!empty($meals[$meal_type]) && $meals[$meal_type] instanceof \Illuminate\Support\Collection && $meals[$meal_type]->count()) {
            $first = $meals[$meal_type]->first();
            $meal_code = $first->mm_code ?? '';
        }

        return [$meal_type, $meal_code];
    }
}
