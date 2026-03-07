<?php

namespace App\Http\Controllers\Web;

use App\Contracts\FoodRepositoryInterface;
use App\Domain\Models\Food;
use App\Jobs\ProcessFoodImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminFoodController extends AdminController
{
    public function __construct(private readonly FoodRepositoryInterface $food_repository)
    {
    }

    public function index(Request $request)
    {
        [$q, $per_page, $page] = $this->paginationParams($request);

        $foods = $this->food_repository->paginate(null, $per_page, $page);

        return view('admin.foods.index', compact('foods', 'q'));
    }

    public function search(Request $request): JsonResponse
    {
        return $this->doSearch(
            $request,
            Food::class,
            ['mf_code', 'mf_name', 'mf_type', 'mf_cals', 'mf_image_url', 'mf_image_disk', 'mf_image_variants'],
            ['mf_name', 'mf_type', 'mf_code'],
            function (Food $food) {
                return [
                  'code' => $food->mf_code,
                  'name' => $food->mf_name,
                  'type' => $food->mf_type,
                  'cals' => $food->mf_cals,
                  'image_url' => $food->getImageVariantUrl('webp', 50),
                ];
            },
            20
        );
    }

    public function create(): View
    {
        $food = new Food();

        return view('admin.foods.create', compact('food'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $image_path = '';
        $image_disk = 'r2';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();
            $image_path = $file->storeAs('foods/' . date('Y/m'), $filename, $image_disk);
        }

        $payload = [
          'mf_name' => $validated['name'],
          'mf_type' => $validated['type'],
          'mf_image_url' => $image_path,
          'mf_image_disk' => $image_disk,
          'mf_cals' => $validated['cals'] ?? null,
          'mf_pfcfw' => [
            'proteins' => (float)($validated['proteins'] ?? 0),
            'fat' => (float)($validated['fat'] ?? 0),
            'carbs' => (float)($validated['carbs'] ?? 0),
            'fiber' => (float)($validated['fiber'] ?? 0),
            'water' => (float)($validated['water'] ?? 0),
          ],
          'mf_created_by' => $request->user()->mu_code ?? null,
        ];

        $food = $this->food_repository->create($payload);

        if ($image_path) {
            ProcessFoodImage::dispatch($food, $image_path, $image_disk);
        }

        return redirect()->route('admin.foods.index')->with('success', 'Food created.');
    }

    public function edit(Food $food): View
    {
        return view('admin.foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $validated = $this->validateData($request, $food);

        $payload = [
          'mf_name' => $validated['name'],
          'mf_type' => $validated['type'],
          'mf_cals' => $validated['cals'] ?? null,
          'mf_pfcfw' => [
            'proteins' => (float)($validated['proteins'] ?? 0),
            'fat' => (float)($validated['fat'] ?? 0),
            'carbs' => (float)($validated['carbs'] ?? 0),
            'fiber' => (float)($validated['fiber'] ?? 0),
            'water' => (float)($validated['water'] ?? 0),
          ],
          'mf_updated_by' => $request->user()->mu_code ?? null,
        ];

        $new_path = $food->getAttributes()['mf_image_url'] ?? null;
        $image_disk = 'r2';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();
            $new_path = $file->storeAs('foods/' . date('Y/m'), $filename, $image_disk);

            $old_path = $food->getAttributes()['mf_image_url'] ?? null;
            $old_disk = $food->getAttributes()['mf_image_disk'] ?? 'public';

            try {
                if ($old_path && Storage::disk($old_disk)->exists($old_path)) {
                    Storage::disk($old_disk)->delete($old_path);
                }
            } catch (\Throwable $e) {
            }

            $payload['mf_image_url'] = $new_path;
            $payload['mf_image_disk'] = $image_disk;
        }

        $updated_food = $this->food_repository->update($food, $payload);

        if ($new_path) {
            ProcessFoodImage::dispatch($updated_food, $new_path, $image_disk);
        }

        return redirect()->route('admin.foods.index')->with('success', 'Food updated.');
    }

    public function destroy(Food $food): RedirectResponse
    {
        $this->food_repository->delete($food);

        return redirect()->route('admin.foods.index')->with('success', 'Food deleted.');
    }

    private function validateData(Request $request, ?Food $food = null): array
    {
        // making image not required until cdn problem will be resolved
        $image_rules = ['sometimes', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp,avif', 'max:5120'];

        $name_rules = $food
          ? ['required', 'string', 'max:255', Rule::unique('mm_foods', 'mf_name')->whereNull('mf_deleted_at')->ignore($food->mf_code, 'mf_code')]
          : ['required', 'string', 'max:255', Rule::unique('mm_foods', 'mf_name')->whereNull('mf_deleted_at')];

        $rules = [
          'name' => $name_rules,
          'type' => ['required', Rule::in(['food', 'drink'])],
          'image' => $image_rules,
          'cals' => ['required', 'integer', 'min:0'],
          'proteins' => ['required', 'numeric', 'min:0'],
          'fat' => ['required', 'numeric', 'min:0'],
          'carbs' => ['required', 'numeric', 'min:0'],
          'fiber' => ['required', 'numeric', 'min:0'],
          'water' => [
            Rule::requiredIf(fn () => (string)$request->input('type') === 'drink'),
            'nullable',
            'numeric',
            'min:0',
          ],
        ];

        return $request->validate($rules);
    }
}
