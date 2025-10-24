<?php

namespace App\Contracts;

use App\Domain\Models\UserRole;

interface UserRoleRepositoryInterface
{
    /** @return UserRole[] */
    public function all(): array;
    public function create(array $data): UserRole;
    public function update(UserRole $user_role, array $data): UserRole;
    public function delete(UserRole $user_role): bool;
    public function restore(UserRole $user_role): bool;
}
