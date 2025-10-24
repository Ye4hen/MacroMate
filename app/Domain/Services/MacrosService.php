<?php

namespace App\Domain\Services;

use App\Domain\Models\User;
use Illuminate\Validation\ValidationException;

class MacrosService
{
    /**
     * Calculate daily macros for a user (percentages + grams + water/fiber).
     *
     * Returns structure compatible with your existing controllers:
     * [
     *   'calories' => int,
     *   'protein' => ['percent' => int, 'grams' => int],
     *   'fat' => ['percent' => int, 'grams' => int],
     *   'carbs' => ['percent' => int, 'grams' => int],
     *   'fiber' => int,
     *   'water' => int,
     * ]
     */
    public function calculateDailyMacrosForUser(User $user, ?int $override_calories = null): array
    {
        $plan = $user->plan;
        $pfc = (array) ($plan->mp_pfc ?? []);
        $calories_index = $plan->mp_cal_index ?? 1;

        $settings = (array) ($user->mu_settings ?? []);

        $calories = $override_calories
          ?? ($settings['calories'] ?? (int) round(($user->mu_weight ?? 70) * 30 * $calories_index));

        $proteins_max_percent = $this->computeProteinsMaxPercent((float) ($user->mu_weight ?? 70), $calories);

        $proteins_percent = (int) ($settings['protein_percent'] ?? $pfc['proteins'] ?? 30);
        $proteins_percent = min($proteins_percent, $proteins_max_percent);

        $fat_percent = (int) ($settings['fat_percent'] ?? $pfc['fat'] ?? 25);
        $carbs_percent = (int) ($settings['carbs_percent'] ?? $pfc['carbs'] ?? 45);

        $total_percent = $proteins_percent + $fat_percent + $carbs_percent;

        if ($total_percent < 100) {
            $carbs_percent += 100 - $total_percent;
        }

        // derive grams
        $proteins_grams = (int) round(($calories * ($proteins_percent / 100)) / 4);
        $fat_grams = (int) round(($calories * ($fat_percent / 100)) / 9);
        $carbs_grams = (int) round(($calories * ($carbs_percent / 100)) / 4);

        $water = $settings['water'] ?? $pfc['water'] ?? 2000;
        $fiber = $settings['fiber'] ?? $pfc['fiber'] ?? 30;

        return [
          'calories' => $calories,
          'protein' => ['percent' => $proteins_percent, 'grams' => $proteins_grams],
          'fat' => ['percent' => $fat_percent, 'grams' => $fat_grams],
          'carbs' => ['percent' => $carbs_percent, 'grams' => $carbs_grams],
          'fiber' => $fiber,
          'water' => $water,
          'proteins_max_percent' => $proteins_max_percent,
        ];
    }

    /**
     * Compute maximum allowed protein percent (rounded int) from weight + calories.
     * Formula from your code: (2.5 * weight * 4) / calories * 100
     */
    public function computeProteinsMaxPercent(float $weight, int $calories): int
    {
        if ($calories <= 0) {
            return 100;
        }

        return (int) round(((2.5 * $weight * 4) / $calories) * 100);
    }

    /**
     * Validate that percentages sum to 100. Returns true/false.
     */
    public function validatePercentagesStrict(int $proteins_percent, int $fat_percent, int $carbs_percent): bool
    {
        return ($proteins_percent + $fat_percent + $carbs_percent) === 100;
    }

    /**
     * Throw ValidationException with helpful messages if percentages do not sum to 100.
     */
    public function validatePercentagesOrThrow(int $proteins_percent, int $fat_percent, int $carbs_percent): void
    {
        if (! $this->validatePercentagesStrict($proteins_percent, $fat_percent, $carbs_percent)) {
            throw ValidationException::withMessages([
              'proteins' => ['The sum of Protein, Fat, and Carbs percentages must be exactly 100%.'],
              'fat' => ['The sum of Protein, Fat, and Carbs percentages must be exactly 100%.'],
              'carbs' => ['The sum of Protein, Fat, and Carbs percentages must be exactly 100%.'],
            ]);
        }
    }

    /**
     * Utility: derive grams from percentages and calories (mirrors derive logic).
     *
     * Returns ['protein' => int, 'fat' => int, 'carbs' => int]
     */
    public function deriveGramsFromPercentages(int $calories, int $proteins_percent, int $fat_percent, int $carbs_percent): array
    {
        $proteins_grams = (int) round(($calories * ($proteins_percent / 100)) / 4);
        $fat_grams = (int) round(($calories * ($fat_percent / 100)) / 9);
        $carbs_grams = (int) round(($calories * ($carbs_percent / 100)) / 4);

        return [
          'protein' => $proteins_grams,
          'fat' => $fat_grams,
          'carbs' => $carbs_grams,
        ];
    }
}
