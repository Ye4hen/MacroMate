<?php

namespace Tests\Feature\Api;

use App\Domain\Models\User;
use App\Domain\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    protected User|JWTSubject $admin_user;
    protected User|JWTSubject $sub_admin_user;
    protected User|JWTSubject $premium_user;
    protected User|JWTSubject $regular_user;
    protected array $auth_header;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\TestUserRolesSeeder::class);

        $this->admin_user = User::factory()->create(['mu_role' => 'admin']);
        $this->sub_admin_user = User::factory()->create(['mu_role' => 'sub_admin']);
        $this->premium_user = User::factory()->create(['mu_role' => 'premium_user']);
        $this->regular_user = User::factory()->create(['mu_role' => 'user']);

        $token = JWTAuth::fromUser($this->admin_user);

        $this->auth_header = ['Authorization' => 'Bearer ' . $token];
    }

    public function test_index_returns_user_roles(): void
    {
        $response = $this->getJson('/api/user-roles', $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonCount(4, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'code',
                    'name',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $data = $response->json('data');
        $actual = collect($data)->mapWithKeys(function ($item) {
            return [$item['code'] => $item['name']];
        })->sortKeys()->toArray();

        $expected = [
            'admin' => 'Admin',
            'premium_user' => 'Premium User',
            'sub_admin' => 'Sub Admin',
            'user' => 'User',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function test_index_unauthorized_without_token(): void
    {
        $response = $this->getJson('/api/user-roles');

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'Unauthorized',
        ]);
    }

    public function test_index_forbidden_for_non_admin(): void
    {
        $users = [
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->getJson('/api/user-roles', $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_store_creates_new_user_role(): void
    {
        $data = [
            'code' => 'super_admin',
            'name' => 'Super Administrator',
        ];

        $response = $this->postJson('/api/user-role', $data, $this->auth_header);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'code',
                'name',
                'created_at',
                'updated_at',
            ],
        ]);
        $response->assertJsonFragment([
            'code' => 'super_admin',
            'name' => 'Super Administrator',
        ]);

        $this->assertDatabaseHas('mm_user_roles', [
            'mur_code' => 'super_admin',
            'mur_name' => 'Super Administrator',
            'mur_deleted_at' => null,
        ]);
    }

    public function test_store_creates_new_user_role_with_invalid_data(): void
    {
        $data = [
            'code' => 2,
            'wrong_field' => 'random data',
        ];

        $response = $this->postJson('/api/user-role', $data, $this->auth_header);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'mur_code' => [
                    0 => 'The mur code field must be a string.',
                ],
                'mur_name' => [
                    0 => 'The mur name field is required.',
                ],
            ],
        ]);
    }

    public function test_store_forbidden_for_non_admin(): void
    {
        $data = [
            'mur_code' => 'super_admin',
            'mur_name' => 'Super Administrator',
        ];

        $users = [
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->postJson('/api/user-role', $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_update_modifies_existing_user_role(): void
    {
        $user_role = UserRole::where('mur_code', 'admin')->first();

        $data = [
            'mur_name' => 'Updated Administrator',
        ];

        $response = $this->patchJson("/api/user-roles/{$user_role->mur_code}", $data, $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'code' => 'admin',
            'name' => 'Updated Administrator',
        ]);

        $this->assertDatabaseHas('mm_user_roles', [
            'mur_code' => 'admin',
            'mur_name' => 'Updated Administrator',
            'mur_deleted_at' => null,
        ]);
    }

    public function test_update_forbidden_for_non_admin(): void
    {
        $user_role = UserRole::where('mur_code', 'admin')->first();
        $data = [
            'mur_name' => 'Updated Administrator',
        ];

        $users = [
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/user-roles/{$user_role->mur_code}", $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_destroy_soft_deletes_user_role(): void
    {
        $user_role = UserRole::where('mur_code', 'admin')->first();

        $response = $this->deleteJson("/api/user-roles/{$user_role->mur_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "User role “{$user_role->mur_name}” was deleted successfully.",
        ]);

        $this->assertSoftDeleted('mm_user_roles', [
            'mur_code' => 'admin',
        ]);
    }

    public function test_destroy_forbidden_for_non_admin(): void
    {
        $user_role = UserRole::where('mur_code', 'admin')->first();

        $users = [
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->deleteJson("/api/user-roles/{$user_role->mur_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_recovers_soft_deleted_user_role(): void
    {
        $user_role = UserRole::where('mur_code', 'admin')->first();
        $user_role->delete();

        $response = $this->patchJson("/api/user-roles/restore/{$user_role->mur_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "User role “{$user_role->mur_name}” was restored successfully.",
        ]);

        $this->assertDatabaseHas('mm_user_roles', [
            'mur_code' => 'admin',
            'mur_deleted_at' => null,
        ]);
    }

    public function test_restore_forbidden_for_non_admin(): void
    {
        $user_role = UserRole::where('mur_code', 'admin')->first();
        $user_role->delete();

        $users = [
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/user-roles/restore/{$user_role->mur_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_not_found_for_nonexistent_code(): void
    {
        $response = $this->patchJson('/api/user-roles/restore/nonexistent', [], $this->auth_header);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'User role not found.',
        ]);
    }
}
