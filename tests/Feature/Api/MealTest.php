<?php

namespace Tests\Feature\Api;

use App\Domain\Models\Meal;
use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class MealTest extends TestCase
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
        $this->seed(\Database\Seeders\TestUsersSeeder::class);
        $this->seed(\Database\Seeders\TestFoodsSeeder::class);
        $this->seed(\Database\Seeders\TestMealsSeeder::class);

        $this->admin_user = User::factory()->create(['mu_role' => 'admin']);
        $this->sub_admin_user = User::factory()->create(['mu_role' => 'sub_admin']);
        $this->premium_user = User::factory()->create(['mu_role' => 'premium_user']);
        $this->regular_user = User::factory()->create(['mu_role' => 'user']);

        $token = JWTAuth::fromUser($this->admin_user);

        $this->auth_header = ['Authorization' => 'Bearer ' . $token];
    }

    public function test_index_returns_meals(): void
    {
        $response = $this->getJson('/api/meals', $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'code',
                    'type',
                    'order',
                    'date',
                    'creator',
                    'foods',
                    'nutrients',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_index_unauthorized_without_token(): void
    {
        $response = $this->getJson('/api/meals');

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
            $response = $this->getJson('/api/meals', $header);

            $response->assertStatus(200);
        }
    }

    public function test_store_creates_new_meal(): void
    {
        $data = [
            'type' => 'Breakfast',
            'order' => 1,
            'date' => '2025-08-14',
            'foods' => [
                [
                    'code' => 'F001',
                    'quantity' => 100,
                    'unit' => 'grams',
                ],
            ],
        ];

        $response = $this->postJson('/api/meal', $data, $this->auth_header);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'code',
                'type',
                'order',
                'date',
                'creator',
                'foods',
                'nutrients',
                'created_at',
                'updated_at',
            ],
        ]);
        $response->assertJsonFragment([
            'type' => 'Breakfast',
            'order' => 1,
            'date' => '2025-08-14',
            'foods' => [
                [
                    'code' => 'F001',
                    'name' => 'Apple',
                    'quantity' => 100,
                    'unit' => 'grams',
                ],
            ],
        ]);

        $this->assertDatabaseHas('mm_meals', [
            'mm_type' => 'Breakfast',
            'mm_order' => 1,
            'mm_date' => '2025-08-14',
            'mm_deleted_at' => null,
        ]);
    }

    public function test_store_creates_new_meal_with_invalid_data(): void
    {
        $data = [
            'type' => 'invalid_type',
            'order' => -1,
            'date' => 'invalid_date',
            'foods' => [
                [
                    'code' => 'nonexistent_food',
                    'quantity' => -10,
                    'unit' => '',
                ],
            ],
        ];

        $response = $this->postJson('/api/meal', $data, $this->auth_header);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'mm_type' => [
                    'The selected mm type is invalid.',
                ],
                'mm_order' => [
                    'The mm order field must be at least 1.',
                ],
                'mm_date' => [
                    'The mm date field must be a valid date.',
                ],
                'foods.0.code' => [
                    'The selected foods.0.code is invalid.',
                ],
                'foods.0.quantity' => [
                    'The foods.0.quantity field must be at least 1.',
                ],
                'foods.0.unit' => [
                    'The foods.0.unit field is required.',
                ],
            ],
        ]);
    }

    public function test_store_accessible_for_all_authenticated_users(): void
    {
        $data = [
            'type' => 'Breakfast',
            'order' => 1,
            'date' => '2025-08-14',
            'foods' => [
                [
                    'code' => 'F001',
                    'quantity' => 100,
                    'unit' => 'grams',
                ],
            ],
        ];

        $users = [
            $this->admin_user,
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->postJson('/api/meal', $data, $header);

            $response->assertStatus(201);
        }
    }

    public function test_update_modifies_existing_meal(): void
    {
        $meal = Meal::where('mm_type', 'Breakfast')->first();

        $data = [
            'order' => 2,
            'date' => '2025-08-15',
        ];

        $response = $this->patchJson("/api/meals/{$meal->mm_code}", $data, $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'code' => $meal->mm_code,
            'order' => 2,
            'date' => '2025-08-15',
        ]);

        $this->assertDatabaseHas('mm_meals', [
            'mm_code' => $meal->mm_code,
            'mm_order' => 2,
            'mm_date' => '2025-08-15',
            'mm_deleted_at' => null,
        ]);
    }

    public function test_update_accessible_for_all_authenticated_users(): void
    {
        $meal = Meal::where('mm_type', 'Breakfast')->first();
        $data = [
            'order' => 2,
            'date' => '2025-08-15',
        ];

        $users = [
            $this->admin_user,
            $this->sub_admin_user,
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/meals/{$meal->mm_code}", $data, $header);

            $response->assertStatus(200);
        }
    }

    public function test_destroy_soft_deletes_meal(): void
    {
        $meal = Meal::where('mm_type', 'Breakfast')->first();

        $response = $this->deleteJson("/api/meals/{$meal->mm_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Meal was deleted successfully.',
        ]);

        $this->assertSoftDeleted('mm_meals', [
            'mm_code' => $meal->mm_code,
        ]);
    }

    public function test_restore_recovers_soft_deleted_meal(): void
    {
        $meal = Meal::where('mm_type', 'Breakfast')->first();
        $meal->delete();

        $response = $this->patchJson("/api/meals/restore/{$meal->mm_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Meal was restored successfully.',
        ]);

        $this->assertDatabaseHas('mm_meals', [
            'mm_code' => $meal->mm_code,
            'mm_deleted_at' => null,
        ]);
    }

    public function test_restore_forbidden_for_non_admin_or_sub_admin(): void
    {
        $meal = Meal::where('mm_type', 'Breakfast')->first();
        $meal->delete();

        $users = [
            $this->premium_user,
            $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/meals/restore/{$meal->mm_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
                'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_not_found_for_nonexistent_code(): void
    {
        $response = $this->patchJson('/api/meals/restore/nonexistent', [], $this->auth_header);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Meal not found.',
        ]);
    }
}
