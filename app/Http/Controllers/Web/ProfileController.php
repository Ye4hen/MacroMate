<?php

namespace App\Http\Controllers\Web;

use App\Domain\Models\Plan;
use App\Domain\Models\User;
use App\Domain\Services\MacrosService;
use App\Domain\Services\StatsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function __construct(
        private readonly StatsService $stats_service,
        private readonly MacrosService $macros_service,
    ) {
    }

    public function index(): View|Application
    {
        return view('profile.index');
    }

    public function showBodyMetrics(): View|Application
    {
        return view('profile.body-metrics');
    }

    public function showSummary(Request $request): View|Application
    {
        $user = $request->user();

        $from = now()->subDays(6);
        $to = now();

        $range_payload = $this->stats_service->totalsForRange($user->mu_code, $from, $to);

        $data = $range_payload['data'] ?? [];

        $dates = array_map(fn ($item) => isset($item['date']) ? Carbon::parse($item['date'])->format('d M') : '', $data);

        $calories = array_map(fn ($item) => $item['totals']['calories'] ?? 0, $data);
        $water = array_map(fn ($item) => $item['totals']['water'] ?? 0, $data);

        $protein = array_map(fn ($item) => $item['totals']['proteins'] ?? 0, $data);
        $fat = array_map(fn ($item) => $item['totals']['fat'] ?? 0, $data);
        $carbs = array_map(fn ($item) => $item['totals']['carbs'] ?? 0, $data);

        $burned_calories = array_map(fn ($item) => $item['totals']['activities_calories'] ?? 0, $data);

        return view('profile.summary', compact(
            'dates',
            'calories',
            'water',
            'protein',
            'fat',
            'carbs',
            'burned_calories',
        ));
    }

    /**
     * JSON endpoint used by the chart component to fetch a requested range and metric
     * Query params:
     *  - metric: calories|water|macros
     *  - range: 7|30|90  (days)
     */
    public function summaryData(Request $request, StatsService $stats)
    {
        $user = $request->user();

        $metric = $request->query('metric', 'calories');
        $range_days = (int)$request->query('range', 7);

        if (!in_array($range_days, [7, 30, 90])) {
            $range_days = 7;
        }

        if (!in_array($metric, ['calories', 'water', 'macros', 'burned_calories'])) {
            $metric = 'calories';
        }

        $from = now()->subDays($range_days - 1);
        $to = now();

        $payload = $stats->totalsForRange($user->mu_code, $from, $to);

        $data = $payload['data'] ?? [];

        $dates = $this->formatRangeDates($data);

        if ($metric === 'calories') {
            $series = [
              [
                'name' => 'Calories',
                'data' => array_map(fn ($item) => $item['totals']['calories'] ?? 0, $data),
                'color' => '#F97316',
              ],
            ];
        } elseif ($metric === 'water') {
            $series = [
              [
                'name' => 'Water (ml)',
                'data' => array_map(fn ($item) => $item['totals']['water'] ?? 0, $data),
                'color' => '#3B82F6',
              ],
            ];
        } elseif ($metric === 'macros') {
            $series = [
              ['name' => 'Protein', 'data' => array_map(fn ($item) => $item['totals']['proteins'] ?? 0, $data), 'color' => '#1C64F2'],
              ['name' => 'Fat', 'data' => array_map(fn ($item) => $item['totals']['fat'] ?? 0, $data), 'color' => '#F97316'],
              ['name' => 'Carbs', 'data' => array_map(fn ($item) => $item['totals']['carbs'] ?? 0, $data), 'color' => '#10B981'],
            ];
        } elseif ($metric === 'burned_calories') {
            $series = [
              ['name' => 'Burned calories', 'data' => array_map(fn ($item) => $item['totals']['activities_calories'] ?? 0, $data), 'color' => '#B91C1C'],
            ];
        }

        return response()->json([
          'dates' => $dates,
          'series' => $series ?? [],
        ]);
    }

    public function showPlan()
    {
        $plans = Plan::pluck('mp_name', 'mp_code')->toArray();

        return view('profile.plan', compact('plans'));
    }

    public function showMacros(Request $request)
    {
        return $this->showMacrosView($request, 'profile.macros');
    }

    public function showMacrosEdit(Request $request)
    {
        return $this->showMacrosView($request, 'profile.macros-edit');
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();

        $previous = url()->previous();

        $previous_is_internal = parse_url($previous, PHP_URL_HOST) === request()->getHost();

        $user->update($request->validated());

        Log::debug($request->all());

        if ($request->has('mu_plan_code')) {
            $this->updatePlan($user);
        }

        return redirect()->to($previous_is_internal ? $previous : route('profile'))
          ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->mu_password)) {
            return back()
              ->withErrors(['current_password' => 'Current password is incorrect.'])
              ->withInput();
        }

        $user->mu_password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('profile')
          ->with('success', 'Password updated successfully.');
    }

    public function updateMacros(Request $request)
    {
        $user = $request->user();
        /** @var \App\Domain\Models\Plan | null $plan */
        $plan = $user->plan;
        $plan_pfc = (array)$plan?->mp_pfc;
        $current_settings = (array)$user->mu_settings;

        $calories_for_limit = (int) ($request->input('calories') ?? $current_settings['calories'] ?? (int) round(($user->mu_weight ?? 70) * 30 * ($user->plan->mp_cal_index ?? 1)));
        $proteins_max_percent = $this->macros_service->computeProteinsMaxPercent((float) ($user->mu_weight ?? 70), $calories_for_limit);

        $validated = $request->validate([
          'calories' => 'numeric|min:500',
          'protein_percent' => "numeric|min:0|max:{$proteins_max_percent}",
          'protein_grams' => 'numeric|min:30',
          'fat_percent' => 'numeric|min:0|max:100',
          'fat_grams' => 'numeric|min:40',
          'carbs_percent' => 'numeric|min:0|max:100',
          'carbs_grams' => 'numeric|min:30',
          'fiber' => 'numeric|min:10',
          'water' => 'numeric|min:500',
        ]);

        $protein = (int) ($request->input('protein_percent') ?? $current_settings['protein_percent'] ?? $plan_pfc['proteins'] ?? 0);
        $fat = (int) ($request->input('fat_percent') ?? $current_settings['fat_percent'] ?? $plan_pfc['fat'] ?? 0);
        $carbs = (int) ($request->input('carbs_percent') ?? $current_settings['carbs_percent'] ?? $plan_pfc['carbs'] ?? 0);

        if (! $this->macros_service->validatePercentagesStrict($protein, $fat, $carbs)) {
            return back()
              ->withInput()
              ->withErrors([
                'protein_percent' => 'The sum of Protein, Fat, and Carbs percentages must be exactly 100%.',
                'fat_percent' => 'The sum of Protein, Fat, and Carbs percentages must be exactly 100%.',
                'carbs_percent' => 'The sum of Protein, Fat, and Carbs percentages must be exactly 100%.',
              ]);
        }

        $settings = array_merge($current_settings, $validated);
        $user->mu_settings = $settings;
        $user->save();

        return redirect()->route('profile-macros')
          ->with('success', 'Macros updated successfully!');
    }

    private function showMacrosView(Request $request, string $view)
    {
        $user = $request->user();
        $plan = $user->plan;

        $macros = $this->macros_service->calculateDailyMacrosForUser($user);

        return view($view, compact('plan', 'macros'));
    }

    private function formatRangeDates(array $data): array
    {
        return array_map(function ($item) {
            if (!isset($item['date'])) {
                return '';
            }

            $d = Carbon::parse($item['date']);

            return $d->format('d M');
        }, $data);
    }

    private function updatePlan(User $user)
    {
        $plan = $user->plan;

        if ($plan) {
            $pfc = (array)($plan->mp_pfc ?? []);
            $calories_index = $plan->mp_cal_index ?? 1;
            $proteins_percent = $pfc['proteins'] ?? 30;
            $fat_percent = $pfc['fat'] ?? 25;
            $carbs_percent = $pfc['carbs'] ?? 45;

            $calories = (int)round(($user->mu_weight ?? 70) * 30 * $calories_index);

            if (empty($user->mu_settings)) {
                $user->mu_settings = [];
            }

            $user->mu_settings['protein_percent'] = $proteins_percent;
            $user->mu_settings['fat_percent'] = $fat_percent;
            $user->mu_settings['carbs_percent'] = $carbs_percent;
            $user->mu_settings['calories'] = $calories;
            $user->save();
        }
    }
}
