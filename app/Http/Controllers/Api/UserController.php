<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserRepositoryInterface;
use App\Domain\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserRepositoryInterface $users)
    {
    }

    /**
     * GET /users
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse|UserResource
    {
        $role = $request->query('role');
        $email = $request->query('email');
        $per_page = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        if ($role && $email) {
            $user_by_email = $this->users->findByEmail($email);
            /** @var \App\Domain\Models\UserRole $user_role */
            $user_role = $user_by_email?->role;

            if ($user_role->mur_code === $role) {
                return new UserResource($user_by_email);
            }

            return response()->json([
              'message' => 'Users with those params not found.',
            ], 404);
        }

        if ($email) {
            return $this->showByEmail($email);
        }

        if ($role) {
            $paginator = User::with(['plan', 'role'])
              ->whereNull('mu_deleted_at')
              ->whereHas('role', fn ($q) => $q->where('mur_code', $role))
              ->paginate($per_page, ['*'], 'page', $page);

            return UserResource::collection($paginator);
        }

        $paginator = $this->users->paginate($per_page, $page);

        return UserResource::collection($paginator);
    }

    /**
     * GET /user/{code}
     */
    public function show(User $user): UserResource|\Illuminate\Http\JsonResponse
    {
        return new UserResource($user);
    }

    /**
     * GET /user/{code}
     */
    public function showByEmail(string $email): UserResource|\Illuminate\Http\JsonResponse
    {
        $user = $this->users->findByEmail($email);

        if (! $user) {
            return response()->json([
              'message' => 'User not found.',
            ], 404);
        }

        return new UserResource($user);
    }

    /**
     * POST /user
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $data = $request->validated();

        $user = $this->users->create($data);

        return new UserResource($user);
    }

    /**
     * PATCH /users/{code}
     */
    public function update(User $user, UpdateUserRequest $request): UserResource|\Illuminate\Http\JsonResponse
    {
        $user = $this->users->update($user, $request->validated());

        return new UserResource($user);
    }

    /**
     * DELETE /users/{code}
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $this->users->delete($user);

        return response()->json([
          'message' => "User “{$user->mu_name}” was deleted successfully.",
        ]);
    }

    /**
     * PATCH /plans/{code}
     */
    public function restore(string $code): \Illuminate\Http\JsonResponse
    {
        $user = User::withTrashed()->where('mu_code', $code)->first();

        if (!$user) {
            return response()->json([
              'message' => 'User not found.',
            ], 404);
        }

        $this->users->restore($user);

        return response()->json([
          'message' => "User “{$user->mu_name}” was restored successfully.",
        ]);
    }
}
