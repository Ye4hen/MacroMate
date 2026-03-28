<?php

namespace App\Domain\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Domain\Models\User;
use App\Domain\Services\CodeGenerator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly CodeGenerator $codes)
    {
    }

    public function findByEmail(string $email): ?User
    {
        return User::with(['plan', 'role'])->where('mu_email', $email)->first();
    }

    public function all(): array
    {
        return User::with(['plan', 'role'])->get()->all();
    }

    public function paginate(int $per_page = 15, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator
    {
        return User::with(['plan', 'role'])->paginate($per_page, ['*'], 'page', $page);
    }

    public function filterByRoleCode(string $code): array
    {
        return User::with(['plan', 'role'])->whereHas('role', function ($query) use ($code) {
            $query->where('mur_code', $code);
        })->get()->all();
    }

    public function create(array $data): User
    {
        $user = User::create($data);

        $user->mu_code = $this->codes->generateCode();
        $user->save();

        return $user->load(['plan', 'role']);
    }

    public function update(User $user, array $data): User
    {
        $user->fill($data)->save();

        return $user->load(['plan', 'role']);
    }

    public function delete(User $user): bool
    {
        return (bool)$user->delete();
    }

    public function restore(User $user): bool
    {
        return $user->restore();
    }
}
