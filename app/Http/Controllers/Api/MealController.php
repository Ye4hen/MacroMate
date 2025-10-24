<?php

namespace App\Http\Controllers\Api;

use App\Contracts\MealRepositoryInterface;
use App\Domain\Models\Meal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\MealResource;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function __construct(private readonly MealRepositoryInterface $meals)
    {
    }

    /**
     * GET /meals
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|array|\Illuminate\Http\JsonResponse
    {
        $creator = $request->query('user');
        $foods = $request->query('foods')
            ? explode(',', $request->query('foods'))
            : [];
        $day = $request->query('day');
        $per_page = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        $paginator = $this->meals->paginate(
            !$creator,
            true,
            per_page: $per_page,
            page: $page,
            creator: $creator,
            food_codes: $foods,
            day: $day,
        );

        return MealResource::collection($paginator);
    }

    /**
     * GET /meal/{code}
     */
    public function show(Meal $meal): MealResource|\Illuminate\Http\JsonResponse
    {
        return new MealResource($meal);
    }

    /**
     * POST /meal
     */
    public function store(StoreMealRequest $request): MealResource
    {
        $data = $request->validated();

        $user = auth()->user();

        if (!$user instanceof \App\Domain\Models\User) {
            abort(403, 'Unauthorized user instance.');
        }

        $data['mm_user'] = $user->getUserCode();

        $meal = $this->meals->create($data);

        return new MealResource($meal);
    }

    /**
     * PATCH /meals/{code}
     */
    public function update(Meal $meal, UpdateMealRequest $request): MealResource|\Illuminate\Http\JsonResponse
    {
        $meal = $this->meals->update($meal, $request->validated());

        return new MealResource($meal);
    }

    /**
     * DELETE /meals/{code}
     */
    public function destroy(Meal $meal): \Illuminate\Http\JsonResponse
    {
        $this->meals->delete($meal);

        return response()->json([
            'message' => 'Meal was deleted successfully.',
        ]);
    }

    /**
     * PATCH /meals/{code}
     */
    public function restore(string $code): \Illuminate\Http\JsonResponse
    {
        $meal = Meal::withTrashed()->where('mm_code', $code)->first();

        if (!$meal) {
            return response()->json([
                'message' => 'Meal not found.',
            ], 404);
        }

        $this->meals->restore($meal);

        return response()->json([
            'message' => 'Meal was restored successfully.',
        ]);
    }
}
