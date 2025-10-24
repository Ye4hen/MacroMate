<?php

namespace App\Contracts;

use App\Domain\Models\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    /** @return User[] */
    public function all(): array;
    public function paginate(int $per_page = 15, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator;
    /** @return User[] */
    public function filterByRoleCode(string $code): array;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function restore(User $user): bool;
}
