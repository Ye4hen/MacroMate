<?php

namespace Tests\Feature\Api;

use App\Domain\Models\Activity;
use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class ActivityTest extends TestCase
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
        $this->seed(\Database\Seeders\TestPlansSeeder::class);
        $this->seed(\Database\Seeders\TestUsersSeeder::class);
        $this->seed(\Database\Seeders\TestActivitiesSeeder::class);

        $this->admin_user = User::factory()->create(['mu_role' => 'admin']);
        $this->sub_admin_user = User::factory()->create(['mu_role' => 'sub_admin']);
        $this->premium_user = User::factory()->create(['mu_role' => 'premium_user']);
        $this->regular_user = User::factory()->create(['mu_role' => 'user']);

        $token = JWTAuth::fromUser($this->admin_user);

        $this->auth_header = ['Authorization' => 'Bearer ' . $token];
    }

    public function test_index_returns_activities(): void
    {
        $response = $this->getJson('/api/activities', $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'code',
                    'name',
                    'calories',
                    'plans',
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
            'running' => 'Running',
            'swimming' => 'Swimming',
            'weightlifting' => 'Weightlifting',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function test_index_unauthorized_without_token(): void
    {
        $response = $this->getJson('/api/activities');

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'Unauthorized',
        ]);
    }

    public function test_index_accessible_for_all_authenticated_users(): void
    {
        $users = [
            $this->admin_user,
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->getJson('/api/activities', $header);

            $response->assertStatus(200);
        }
    }

    public function test_store_creates_new_activity(): void
    {
        $data = [
            'name' => 'Yoga',
            'calories' => 200,
        ];

        $response = $this->postJson('/api/activity', $data, $this->auth_header);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'code',
                'name',
                'calories',
                'plans',
                'created_at',
                'updated_at',
            ],
        ]);
        $response->assertJsonFragment([
            'name' => 'Yoga',
            'calories' => 200,
        ]);

        $this->assertDatabaseHas('mm_activities', [
            'ma_name' => 'Yoga',
            'ma_cals' => 200,
            'ma_deleted_at' => null,
        ]);
    }

    public function test_store_creates_new_activity_with_invalid_data(): void
    {
        $data = [
            'name' => '',
            'calories' => -100,
        ];

        $response = $this->postJson('/api/activity', $data, $this->auth_header);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'ma_name' => [
                    'The ma name field is required.',
                ],
                'ma_cals' => [
                    'The ma cals field must be at least 0.',
                ],
            ],
        ]);
    }

    public function test_store_forbidden_for_regular_users(): void
    {
        $data = [
            'name' => 'Yoga',
            'calories' => 200,
        ];

        $users = [
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->postJson('/api/activity', $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_update_modifies_existing_activity(): void
    {
        $activity = Activity::where('ma_code', 'running')->first();

        $data = [
            'name' => 'Updated Running',
            'calories' => 600,
        ];

        $response = $this->patchJson("/api/activities/{$activity->ma_code}", $data, $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'code' => 'running',
            'name' => 'Updated Running',
            'calories' => 600,
        ]);

        $this->assertDatabaseHas('mm_activities', [
            'ma_code' => 'running',
            'ma_name' => 'Updated Running',
            'ma_cals' => 600,
            'ma_deleted_at' => null,
        ]);
    }

    public function test_update_forbidden_for_regular_users(): void
    {
        $activity = Activity::where('ma_code', 'running')->first();
        $data = [
            'name' => 'Updated Running',
            'calories' => 600,
        ];

        $users = [
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/activities/{$activity->ma_code}", $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_destroy_soft_deletes_activity(): void
    {
        $activity = Activity::where('ma_code', 'running')->first();

        $response = $this->deleteJson("/api/activities/{$activity->ma_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "Activity “{$activity->ma_name}” was deleted successfully.",
        ]);

        $this->assertSoftDeleted('mm_activities', [
            'ma_code' => 'running',
        ]);
    }

    public function test_destroy_forbidden_for_regular_users(): void
    {
        $activity = Activity::where('ma_code', 'running')->first();

        $users = [
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->deleteJson("/api/activities/{$activity->ma_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_recovers_soft_deleted_activity(): void
    {
        $activity = Activity::where('ma_code', 'running')->first();
        $activity->delete();

        $response = $this->patchJson("/api/activities/restore/{$activity->ma_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "Activity “{$activity->ma_name}” was restored successfully.",
        ]);

        $this->assertDatabaseHas('mm_activities', [
            'ma_code' => 'running',
            'ma_deleted_at' => null,
        ]);
    }

    public function test_restore_forbidden_for_non_admin_or_sub_admin(): void
    {
        $activity = Activity::where('ma_code', 'running')->first();
        $activity->delete();

        $users = [
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/activities/restore/{$activity->ma_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_not_found_for_nonexistent_code(): void
    {
        $response = $this->patchJson('/api/activities/restore/nonexistent', [], $this->auth_header);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Activity not found.',
        ]);
    }
}
