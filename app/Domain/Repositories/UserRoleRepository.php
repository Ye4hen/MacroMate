<?php

namespace App\Domain\Repositories;

use App\Contracts\UserRoleRepositoryInterface;
use App\Domain\Models\UserRole;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    public function all(): array
    {
        return UserRole::get()->all();
    }

    public function create(array $data): UserRole
    {
        return UserRole::create($data);
    }

    public function update(UserRole $user_role, array $data): UserRole
    {
        $user_role->fill($data)->save();

        return $user_role;
    }

    public function delete(UserRole $user_role): bool
    {
        return (bool)$user_role->delete();
    }

    public function restore(UserRole $user_role): bool
    {
        return $user_role->restore();
    }
}
