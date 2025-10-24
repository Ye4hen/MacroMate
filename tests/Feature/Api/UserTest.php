<?php

namespace Tests\Feature\Api;

use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected array $auth_header;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\TestPlansSeeder::class);
        $this->seed(\Database\Seeders\TestUserRolesSeeder::class);

        $auth_user = User::factory()->create([
          'mu_email' => 'testadmin@example.com',
          'mu_role' => 'admin',
          'mu_plan_code' => 'mp_bulk',
        ]);

        $token = JWTAuth::fromUser($auth_user);

        $this->auth_header = [
          'Authorization' => "Bearer {$token}",
          'Accept' => 'application/json',
        ];
    }

    public function test_index_returns_paginated_users(): void
    {
        User::factory()->count(20)->create();

        $response = $this->getJson('/api/users?per_page=10', $this->auth_header);

        $response->assertStatus(200)
          ->assertJsonStructure(['data', 'links', 'meta']);

        $this->assertCount(10, $response->json('data'));
    }

    public function test_show_returns_single_user(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->mu_code}", $this->auth_header);

        $response->assertStatus(200)
          ->assertJsonFragment([
            'code' => $user->mu_code,
            'name' => $user->mu_name,
            'email' => $user->mu_email,
          ]);
    }

    public function test_store_creates_user_and_returns_resource(): void
    {
        $payload = [
          'name' => 'Test User',
          'email' => 'test+' . time() . '@example.com',
          'password' => 'Password123!',
          'password_confirmation' => 'Password123!',
          'role' => 'user',
        ];

        $this->postJson('/api/user', [], $this->auth_header)->assertStatus(422);

        $response = $this->postJson('/api/user', $payload, $this->auth_header);

        $response->assertStatus(201)
          ->assertJsonFragment([
            'email' => $payload['email'],
            'name' => $payload['name'],
          ]);

        $this->assertDatabaseHas('mm_users', [
          'mu_email' => $payload['email'],
          'mu_name' => $payload['name'],
        ]);
    }

    public function test_update_modifies_user(): void
    {
        $user = User::factory()->create([
          'mu_name' => 'Old Name',
        ]);

        $payload = [
          'name' => 'New Name',
        ];

        $response = $this->patchJson("/api/users/{$user->mu_code}", $payload, $this->auth_header);

        $response->assertStatus(200)
          ->assertJsonFragment(['name' => 'New Name']);

        $this->assertDatabaseHas('mm_users', [
          'mu_code' => $user->mu_code,
          'mu_name' => 'New Name',
        ]);
    }

    public function test_delete_marks_user_as_deleted(): void
    {
        $user = User::factory()->create();
        $this->deleteJson("/api/users/{$user->mu_code}", [], $this->auth_header)
          ->assertStatus(200);

        $this->assertSoftDeleted('mm_users', [
          'mu_code' => $user->mu_code,
        ]);
    }

    public function test_restore_restores_deleted_user(): void
    {
        $user = User::factory()->create(['mu_deleted_at' => now()]);

        $this->patchJson("/api/users/restore/{$user->mu_code}", [], $this->auth_header)
          ->assertStatus(200);

        $this->assertDatabaseHas('mm_users', [
          'mu_code' => $user->mu_code,
          'mu_deleted_at' => null,
        ]);
    }

    public function test_index_returns_paginated_users_with_invalid_token(): void
    {
        $new_auth_header = [
          'Authorization' => 'Bearer some_wrong_token',
          'Accept' => 'application/json',
        ];

        User::factory()->count(20)->create();

        $response = $this->getJson('/api/users?per_page=10', $new_auth_header);

        $response->assertStatus(401)
          ->assertJsonFragment([
            'error' => 'Token invalid',
          ]);
    }

    public function test_delete_marks_user_deleted_and_restore_with_invalid_role(): void
    {
        $auth_user = User::factory()->create([
          'mu_email' => 'testsubadmin@example.com',
          'mu_role' => 'sub_admin',
        ]);

        $token = JWTAuth::fromUser($auth_user);

        $new_auth_header = [
          'Authorization' => "Bearer {$token}",
          'Accept' => 'application/json',
        ];

        $user = User::factory()->create(['mu_deleted_at' => now()]);

        $restore_resp = $this->patchJson("/api/users/restore/{$user->mu_code}", [], $new_auth_header);

        $restore_resp->assertStatus(403)
          ->assertJsonFragment([
            'error' => 'User does not have the right role.',
          ]);
    }
}
