<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserRoleRepositoryInterface;
use App\Domain\Models\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRoleRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Http\Resources\UserRoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleController extends Controller
{
    public function __construct(private UserRoleRepositoryInterface $user_roles)
    {
    }

    /**
     * GET /users
     */
    public function index(): JsonResource
    {
        $all = $this->user_roles->all();

        return UserRoleResource::collection($all);
    }

    /**
     * GET /user/{code}
     */
    public function show(UserRole $user_role): UserRoleResource|\Illuminate\Http\JsonResponse
    {
        return new UserRoleResource($user_role);
    }

    /**
     * POST /user
     */
    public function store(StoreUserRoleRequest $request): UserRoleResource
    {
        $data = $request->validated();

        $user_role = $this->user_roles->create($data);

        return new UserRoleResource($user_role);
    }

    /**
     * PATCH /users/{code}
     */
    public function update(UserRole $user_role, UpdateUserRoleRequest $request): UserRoleResource|\Illuminate\Http\JsonResponse
    {
        $user_role = $this->user_roles->update($user_role, $request->validated());

        return new UserRoleResource($user_role);
    }

    /**
     * DELETE /users/{code}
     */
    public function destroy(UserRole $user_role): \Illuminate\Http\JsonResponse
    {
        $this->user_roles->delete($user_role);

        return response()->json([
            'message' => "User role “{$user_role->mur_name}” was deleted successfully.",
        ]);
    }

    /**
     * PATCH /plans/{code}
     */
    public function restore(string $code): \Illuminate\Http\JsonResponse
    {
        $user_role = UserRole::withTrashed()->where('mur_code', $code)->first();

        if (!$user_role) {
            return response()->json([
                'message' => 'User role not found.',
            ], 404);
        }

        $this->user_roles->restore($user_role);

        return response()->json([
            'message' => "User role “{$user_role->mur_name}” was restored successfully.",
        ]);
    }
}
