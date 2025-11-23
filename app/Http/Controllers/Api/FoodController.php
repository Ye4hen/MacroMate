<?php

namespace App\Http\Controllers\Api;

use App\Contracts\FoodRepositoryInterface;
use App\Domain\Models\Food;
use App\Enums\FoodTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Http\Resources\FoodResource;
use App\Jobs\ProcessFoodImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function __construct(private readonly FoodRepositoryInterface $foods)
    {
    }

    /**
     * GET /foods
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
    {
        $per_page = $request->query('per_page', 15);
        $page = $request->query('page', 1);
        $type = $request->query('type');

        if ($type && !FoodTypeEnum::tryFrom($type)) {
            return response()->json([
              'message' => "Type “{$type}” does not exist.",
            ], 422);
        }

        $paginated_list = $this->foods->paginate(FoodTypeEnum::tryFrom($type), $per_page, $page);

        return FoodResource::collection($paginated_list);
    }

    /**
     * GET /food/{code}
     */
    public function show(Food $food): FoodResource|\Illuminate\Http\JsonResponse
    {
        return new FoodResource($food);
    }

    /**
     * POST /food
     */
    public function store(StoreFoodRequest $request): FoodResource
    {
        $data = $request->validated();

        $user = auth()->user();

        if (!$user instanceof \App\Domain\Models\User) {
            abort(403, 'Unauthorized user instance.');
        }

        $data['mf_created_by'] = $user->getUserCode();

        $image_path = '';
        $image_disk = 'r2';

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();

            $image_path = $file->storeAs('foods/' . date('Y/m'), $filename, $image_disk);

            $data['mf_image_url'] = $image_path;
            $data['mf_image_disk'] = $image_disk;
        }

        $food = $this->foods->create($data);

        if (!empty($image_path)) {
            ProcessFoodImage::dispatch($food, $image_path, $image_disk);
        }

        try {
            Cache::tags(['catalogs', 'catalog:foods'])->flush();
        } catch (\Throwable $e) {
            Log::error('Failed to flush catalogs cache: ' . $e->getMessage());
        }

        return new FoodResource($food);
    }

    /**
     * PATCH /foods/{code}
     */
    public function update(Food $food, UpdateFoodRequest $request): FoodResource|\Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $user = auth()->user();

        if (!$user instanceof \App\Domain\Models\User) {
            abort(403, 'Unauthorized user instance.');
        }

        $data['mf_updated_by'] = $user->getUserCode();

        $old_path = $food->getAttributes()['mf_image_url'] ?? null;
        $old_disk = $food->getAttributes()['mf_image_disk'] ?? 'public';

        $new_image_path = $data['mf_image_url'] ?? null;
        $new_image_disk = $data['mf_image_disk'] ?? ($new_image_path ? 'r2' : null);

        $updated_food = $this->foods->update($food, $data);

        if (!empty($new_image_path)) {
            ProcessFoodImage::dispatch($updated_food, $new_image_path, $new_image_disk);

            try {
                if ($old_path && $old_path !== $new_image_path && Storage::disk($old_disk)->exists($old_path)) {
                    Storage::disk($old_disk)->delete($old_path);
                }
            } catch (\Throwable $e) {
                Log::error('Failed to delete old image: ' . $e->getMessage());
            }
        }

        try {
            Cache::tags(['catalogs', 'catalog:foods'])->flush();
        } catch (\Throwable $e) {
            Log::error('Failed to flush catalogs cache: ' . $e->getMessage());
        }

        return new FoodResource($updated_food);
    }

    /**
     * DELETE /foods/{code}
     */
    public function destroy(Food $food): \Illuminate\Http\JsonResponse
    {
        $this->foods->delete($food);

        return response()->json([
          'message' => "Food “{$food->mf_name}” was deleted successfully.",
        ]);
    }

    /**
     * PATCH /foods/{code}
     */
    public function restore(string $code): \Illuminate\Http\JsonResponse
    {
        $food = Food::withTrashed()->where('mf_code', $code)->first();

        if (!$food) {
            return response()->json([
              'message' => 'Food not found.',
            ], 404);
        }

        $food_with_same_name = Food::where('mf_name', $food->mf_name)->first();

        if ($food_with_same_name) {
            return response()->json([
              'message' => "Food with name “{$food->mf_name}” already exists.",
            ]);
        }

        $this->foods->restore($food);

        return response()->json([
          'message' => "Food “{$food->mf_name}” was restored successfully.",
        ]);
    }
}
