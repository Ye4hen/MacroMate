<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ActivityRepositoryInterface;
use App\Domain\Models\Activity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityController extends Controller
{
    public function __construct(private readonly ActivityRepositoryInterface $activities)
    {
    }

    /**
     * GET /activities
     */
    public function index(Request $request): JsonResource
    {
        $per_page = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        $paginated_list = $this->activities->paginate($per_page, $page);

        return ActivityResource::collection($paginated_list);
    }

    /**
     * GET /activity/{code}
     */
    public function show(Activity $activity): ActivityResource|\Illuminate\Http\JsonResponse
    {
        return new ActivityResource($activity);
    }

    /**
     * PATCH /activities/{code}
     */
    public function update(Activity $activity, UpdateActivityRequest $request): ActivityResource|\Illuminate\Http\JsonResponse
    {
        $activity = $this->activities->update($activity, $request->validated());

        return new ActivityResource($activity);
    }

    /**
     * POST /activity
     */
    public function store(StoreActivityRequest $request): ActivityResource
    {
        $data = $request->validated();

        $activity = $this->activities->create($data);

        return new ActivityResource($activity);
    }

    /**
     * DELETE /activities/{code}
     */
    public function destroy(Activity $activity): \Illuminate\Http\JsonResponse
    {
        $this->activities->delete($activity);

        return response()->json([
            'message' => "Activity “{$activity->ma_name}” was deleted successfully.",
        ]);
    }

    /**
     * PATCH /activities/{code}
     */
    public function restore(string $code): \Illuminate\Http\JsonResponse
    {
        $activity = Activity::withTrashed()->where('ma_code', $code)->first();

        if (!$activity) {
            return response()->json([
                'message' => 'Activity not found.',
            ], 404);
        }

        $this->activities->restore($activity);

        return response()->json([
            'message' => "Activity “{$activity->ma_name}” was restored successfully.",
        ]);
    }
}
