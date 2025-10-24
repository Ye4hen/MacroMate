<?php

namespace Tests\Feature\Api;

use App\Domain\Models\Plan;
use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class PlanTest extends TestCase
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

        $this->admin_user = User::factory()->create(['mu_role' => 'admin']);
        $this->sub_admin_user = User::factory()->create(['mu_role' => 'sub_admin']);
        $this->premium_user = User::factory()->create(['mu_role' => 'premium_user']);
        $this->regular_user = User::factory()->create(['mu_role' => 'user']);

        $token = JWTAuth::fromUser($this->admin_user);

        $this->auth_header = ['Authorization' => 'Bearer ' . $token];
    }

    public function test_index_returns_plans(): void
    {
        $response = $this->getJson('/api/plans', $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'code',
                    'name',
                    'calories_index',
                    'pfc',
                    'activities',
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
            'mp_bulk' => 'Bulk',
            'mp_maintenance' => 'Maintenance',
            'mp_cut' => 'Cut',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function test_index_unauthorized_without_token(): void
    {
        $response = $this->getJson('/api/plans');

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
            $response = $this->getJson('/api/plans', $header);

            $response->assertStatus(200);
        }
    }

    public function test_store_creates_new_plan(): void
    {
        $data = [
            'name' => 'Elite Plan',
            'calories_index' => 2.00,
            'pfc' => [
                'proteins' => 100,
                'fat' => 50,
                'carbs' => 250,
            ],
            'activity_codes' => [],
        ];

        $response = $this->postJson('/api/plan', $data, $this->auth_header);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'code',
                'name',
                'calories_index',
                'pfc',
                'activities',
                'created_at',
                'updated_at',
            ],
        ]);
        $response->assertJsonFragment([
            'name' => 'Elite Plan',
            'calories_index' => 2.00,
            'pfc' => [
                'proteins' => 100,
                'fat' => 50,
                'carbs' => 250,
            ],
        ]);

        $this->assertDatabaseHas('mm_plans', [
            'mp_name' => 'Elite Plan',
            'mp_cal_index' => 2.00,
            'mp_deleted_at' => null,
        ]);
    }

    public function test_store_creates_new_plan_with_invalid_data(): void
    {
        $data = [
            'calories_index' => 'not_an_integer',
            'pfc' => [
                'proteins' => -10,
                'fat' => 'invalid',
            ],
        ];

        $response = $this->postJson('/api/plan', $data, $this->auth_header);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'mp_name' => [
                    'The mp name field is required.',
                ],
                'mp_cal_index' => [
                    'The mp cal index field must be a number.',
                ],
                'mp_pfc.proteins' => [
                    'The mp pfc.proteins field must be at least 0.',
                ],
                'mp_pfc.fat' => [
                    'The mp pfc.fat field must be a number.',
                ],
                'mp_pfc.carbs' => [
                    'The mp pfc.carbs field is required.',
                ],
            ],
        ]);
    }

    public function test_store_forbidden_for_non_admin_or_sub_admin(): void
    {
        $data = [
            'mp_name' => 'Elite Plan',
            'mp_cal_index' => 2000,
            'mp_pfc' => [
                'proteins' => 100,
                'fat' => 50,
                'carbs' => 250,
            ],
            'activity_codes' => [],
        ];

        $users = [
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->postJson('/api/plan', $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_update_modifies_existing_plan(): void
    {
        $plan = Plan::where('mp_code', 'mp_bulk')->first();

        $data = [
            'mp_name' => 'Updated Bulk Plan',
            'mp_cal_index' => 3.50,
        ];

        $response = $this->patchJson("/api/plans/{$plan->mp_code}", $data, $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'code' => 'mp_bulk',
            'name' => 'Updated Bulk Plan',
            'calories_index' => 3.50,
        ]);

        $this->assertDatabaseHas('mm_plans', [
            'mp_code' => 'mp_bulk',
            'mp_name' => 'Updated Bulk Plan',
            'mp_cal_index' => 3.50,
            'mp_deleted_at' => null,
        ]);
    }

    public function test_update_forbidden_for_non_admin_or_sub_admin(): void
    {
        $plan = Plan::where('mp_code', 'mp_bulk')->first();
        $data = [
            'mp_name' => 'Updated Bulk Plan',
        ];

        $users = [
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/plans/{$plan->mp_code}", $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_destroy_soft_deletes_plan(): void
    {
        $plan = Plan::where('mp_code', 'mp_bulk')->first();

        $response = $this->deleteJson("/api/plans/{$plan->mp_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "Plan “{$plan->mp_name}” was deleted successfully.",
        ]);

        $this->assertSoftDeleted('mm_plans', [
            'mp_code' => 'mp_bulk',
        ]);
    }

    public function test_destroy_forbidden_for_non_admin_or_sub_admin(): void
    {
        $plan = Plan::where('mp_code', 'mp_bulk')->first();

        $users = [
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->deleteJson("/api/plans/{$plan->mp_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_recovers_soft_deleted_plan(): void
    {
        $plan = Plan::where('mp_code', 'mp_bulk')->first();
        $plan->delete();

        $response = $this->patchJson("/api/plans/restore/{$plan->mp_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "Plan “{$plan->mp_name}” was restored successfully.",
        ]);

        $this->assertDatabaseHas('mm_plans', [
            'mp_code' => 'mp_bulk',
            'mp_deleted_at' => null,
        ]);
    }

    public function test_restore_forbidden_for_non_admin_or_sub_admin(): void
    {
        $plan = Plan::where('mp_code', 'mp_bulk')->first();
        $plan->delete();

        $users = [
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/plans/restore/{$plan->mp_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_not_found_for_nonexistent_code(): void
    {
        $response = $this->patchJson('/api/plans/restore/nonexistent', [], $this->auth_header);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Plan not found.',
        ]);
    }
}
