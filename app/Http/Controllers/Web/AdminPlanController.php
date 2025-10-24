<?php

namespace App\Http\Controllers\Web;

use App\Contracts\PlanRepositoryInterface;
use App\Domain\Models\Plan;
use App\Domain\Services\MacrosService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminPlanController extends Controller
{
    public function __construct(
        private readonly PlanRepositoryInterface $plan_repository,
        private readonly MacrosService $macros_service,
    ) {
    }

    public function index(Request $request): View
    {
        $plans = $this->plan_repository->all();

        return view('admin.plans.index', compact('plans'));
    }

    public function create(): View
    {
        $plan = new Plan();

        return view('admin.plans.create', compact('plan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $payload = [
          'mp_name' => $validated['name'],
          'mp_cal_index' => $validated['calories_index'],
          'mp_pfc' => [
            'proteins' => (float)($validated['proteins'] ?? 0),
            'fat' => (float)($validated['fat'] ?? 0),
            'carbs' => (float)($validated['carbs'] ?? 0),
            'fiber' => (float)($validated['fiber'] ?? 0),
            'water' => (float)($validated['water'] ?? 0),
          ],
        ];

        $this->plan_repository->create($payload);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created.');
    }

    public function edit(Plan $plan): View
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $this->validateData($request, $plan);

        $payload = [
          'mp_name' => $validated['name'],
          'mp_cal_index' => $validated['calories_index'],
          'mp_pfc' => [
            'proteins' => (float)($validated['proteins'] ?? 0),
            'fat' => (float)($validated['fat'] ?? 0),
            'carbs' => (float)($validated['carbs'] ?? 0),
            'fiber' => (float)($validated['fiber'] ?? 0),
            'water' => (float)($validated['water'] ?? 0),
          ],
        ];

        $this->plan_repository->update($plan, $payload);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        $this->plan_repository->delete($plan);

        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted.');
    }

    private function validateData(Request $request, ?Plan $plan = null): array
    {
        $name_rules = $plan
          ? ['required', 'string', 'max:255', Rule::unique('mm_plans', 'mp_name')->whereNull('mp_deleted_at')->ignore($plan->mp_code, 'mp_code')]
          : ['required', 'string', 'max:255', Rule::unique('mm_plans', 'mp_name')->whereNull('mp_deleted_at')];

        $rules = [
          'name' => $name_rules,
          'calories_index' => ['required', 'numeric', 'min:0.1'],
          'proteins' => ['required', 'numeric', 'min:0'],
          'fat' => ['required', 'numeric', 'min:0'],
          'carbs' => ['required', 'numeric', 'min:0'],
          'fiber' => ['required', 'numeric', 'min:0'],
          'water' => ['required', 'nullable', 'numeric', 'min:0'],
        ];

        $validated = $request->validate($rules);

        $proteins = (int) ($validated['proteins'] ?? 0);
        $fat = (int) ($validated['fat'] ?? 0);
        $carbs = (int) ($validated['carbs'] ?? 0);

        if (! $this->macros_service->validatePercentagesStrict($proteins, $fat, $carbs)) {
            throw ValidationException::withMessages([
              'proteins' => ['The sum of Protein, Fat, and Carbs percentages must be exactly 100%.'],
              'fat' => ['The sum of Protein, Fat, and Carbs percentages must be exactly 100%.'],
              'carbs' => ['The sum of Protein, Fat, and Carbs percentages must be exactly 100%.'],
            ]);
        }

        return $validated;
    }
}
