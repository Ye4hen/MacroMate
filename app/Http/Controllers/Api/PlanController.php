<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PlanRepositoryInterface;
use App\Domain\Models\Plan;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanController extends Controller
{
    public function __construct(private readonly PlanRepositoryInterface $plans)
    {
    }

    /**
     * GET /plans
     */
    public function index(): JsonResource
    {
        $all = $this->plans->all();

        return PlanResource::collection($all);
    }

    /**
     * GET /plan/{code}
     */
    public function show(Plan $plan): PlanResource
    {
        return new PlanResource($plan);
    }

    /**
     * POST /plan
     */
    public function store(StorePlanRequest $request): PlanResource
    {
        $data = $request->validated();

        $plan = $this->plans->create($data);

        return new PlanResource($plan);
    }

    /**
     * PATCH /plans/{code}
     */
    public function update(Plan $plan, UpdatePlanRequest $request): PlanResource
    {
        $plan = $this->plans->update($plan, $request->validated());

        return new PlanResource($plan);
    }

    /**
     * DELETE /plans/{code}
     */
    public function destroy(Plan $plan): \Illuminate\Http\JsonResponse
    {
        $this->plans->delete($plan);

        return response()->json([
            'message' => "Plan “{$plan->mp_name}” was deleted successfully.",
        ]);
    }

    /**
     * PATCH /plans/{code}
     */
    public function restore(string $code): \Illuminate\Http\JsonResponse
    {
        $plan = PLan::withTrashed()->where('mp_code', $code)->first();

        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found.',
            ], 404);
        }

        $this->plans->restore($plan);

        return response()->json([
            'message' => "Plan “{$plan->mp_name}” was restored successfully.",
        ]);
    }
}
