<?php

namespace App\Http\Controllers\Web;

use App\Contracts\ActivityRepositoryInterface;
use App\Domain\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminActivityController extends AdminController
{
    public function __construct(private readonly ActivityRepositoryInterface $activity_repository)
    {
    }

    public function index(Request $request)
    {
        [$q, $per_page, $page] = $this->paginationParams($request);

        $activities = $this->activity_repository->paginate($per_page, $page);

        return view('admin.activities.index', compact('activities', 'q'));
    }

    public function search(Request $request): JsonResponse
    {
        return $this->doSearch(
            $request,
            Activity::class,
            ['ma_code', 'ma_name', 'ma_cals'],
            ['ma_name', 'ma_code'],
            function (Activity $activity) {
                return [
                  'code' => $activity->ma_code,
                  'name' => $activity->ma_name,
                  'cals' => $activity->ma_cals,
                ];
            },
            20
        );
    }

    public function create(): View
    {
        $activity = new Activity();

        return view('admin.activities.create', compact('activity'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $payload = [
          'ma_name' => $validated['name'],
          'ma_cals' => $validated['cals'],
        ];

        $this->activity_repository->create($payload);

        Cache::tags(['catalog:activities'])->flush();

        return redirect()->route('admin.activities.index')->with('success', 'Activity created.');
    }

    public function edit(Activity $activity): View
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $this->validateData($request, $activity);

        $payload = [
          'ma_name' => $validated['name'],
          'ma_cals' => $validated['cals'],
        ];

        $this->activity_repository->update($activity, $payload);

        Cache::tags(['catalogs', 'catalog:activities'])->flush();

        return redirect()->route('admin.activities.index')->with('success', 'Activity updated.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $this->activity_repository->delete($activity);

        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted.');
    }

    private function validateData(Request $request, ?Activity $activity = null): array
    {
        $name_rules = $activity
          ? ['required', 'string', 'max:255', Rule::unique('mm_activities', 'ma_name')->whereNull('ma_deleted_at')->ignore($activity->ma_code, 'ma_code')]
          : ['required', 'string', 'max:255', Rule::unique('mm_activities', 'ma_name')->whereNull('ma_deleted_at')];

        $rules = [
          'name' => $name_rules,
          'cals' => ['required', 'integer', 'min:0'],
        ];

        return $request->validate($rules);
    }
}
