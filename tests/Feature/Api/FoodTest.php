<?php

namespace Tests\Feature\Api;

use App\Domain\Models\Food;
use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FoodTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin_user;
    protected User $sub_admin_user;
    protected User $premium_user;
    protected User $regular_user;
    protected array $auth_header;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\TestFoodsSeeder::class);
        $this->seed(\Database\Seeders\TestPlansSeeder::class);
        $this->seed(\Database\Seeders\TestUserRolesSeeder::class);
        $this->seed(\Database\Seeders\TestUsersSeeder::class);

        $this->admin_user = User::factory()->create(['mu_role' => 'admin', 'mu_code' => 'admin1']);
        $this->sub_admin_user = User::factory()->create(['mu_role' => 'sub_admin', 'mu_code' => 'subadmin1']);
        $this->premium_user = User::factory()->create(['mu_role' => 'premium_user', 'mu_code' => 'premium1']);
        $this->regular_user = User::factory()->create(['mu_role' => 'user', 'mu_code' => 'user1']);

        $token = JWTAuth::fromUser($this->admin_user);

        $this->auth_header = ['Authorization' => 'Bearer ' . $token];
    }

    public function test_index_returns_foods(): void
    {
        $response = $this->getJson('/api/foods', $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonCount(13, 'data');
        $response->assertJsonStructure([
          'data' => [
            '*' => [
              'code',
              'name',
              'type',
              'image_url',
              'calories',
              'pfcfw',
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
          '00000000aFILsgfDi8Q5tXwRv4F' => 'Quinoa & Veggie Protein Bowl',
          '0000000FUy9aiAF3ddbE6Ys' => 'Thai Coconut Quinoa Bowl',
          '0000000TyGasF1oqLAtM31dj2' => 'Mediterranean Bowl with Red Peppers & Feta',
          '000000VfJAa0zivNpiUK5' => 'Greek Quinoa Buddha Bowl',
          '00000mT4lgBHw6EZao2' => 'Summer Quinoa & Veggie Bowl',
          '000003JhFb4d0TBPq' => 'Chicken & Black Bean Quinoa Bowl',
          '0000TLyC7sP3tsF' => 'Mediterranean Quinoa Bowl',
          '0000W7takabKn' => 'Vanilla Protein Shake',
          '000mil3riNo' => 'Cucumber Slices',
          '002k5tnb7' => 'Greek Yogurt',
          '005aaab' => 'Avocado Toast',
          '0nE5E' => 'Grilled Chicken Breast',
          'H2' => 'Grilled Chicken Breast (original)',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function test_index_unauthorized_without_token(): void
    {
        $response = $this->getJson('/api/foods');

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
            $response = $this->getJson('/api/foods', $header);

            $response->assertStatus(200);
        }
    }

    public function test_store_creates_new_food(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('food.jpg', 800, 600)->size(1200); // size in KB
        $data = [
          'name' => 'New Food Item',
          'type' => 'food',
          'image' => $file,
          'calories' => 200,
          'pfcfw' => [
            'proteins' => 10,
            'fat' => 5,
            'carbs' => 30,
            'fiber' => 2,
            'water' => 50,
          ],
          'plan_code' => 'mp_bulk',
        ];

        $headers = array_merge($this->auth_header ?? [], ['Accept' => 'application/json']);
        $response = $this->post('/api/food', $data, $headers);

        $response->assertStatus(201);
        $response->assertJsonStructure([
          'data' => [
            'code',
            'name',
            'type',
            'image_url',
            'calories',
            'pfcfw',
            'created_at',
            'updated_at',
          ],
        ]);

        $image_path = $response->json('data.image_url');
        $this->assertNotEmpty($image_path, 'API did not return an image path');

        $response->assertJsonFragment([
          'name' => 'New Food Item',
          'type' => 'food',
          'image_url' => $image_path,
          'calories' => 200,
          'pfcfw' => [
            'proteins' => 10,
            'fat' => 5,
            'carbs' => 30,
            'fiber' => 2,
            'water' => 50,
          ],
        ]);

        $this->assertDatabaseHas('mm_foods', [
          'mf_name' => 'New Food Item',
          'mf_type' => 'food',
          'mf_cals' => 200,
          'mf_image_url' => $image_path,
          'mf_plan_code' => 'mp_bulk',
          'mf_created_by' => $this->admin_user->mu_code,
          'mf_deleted_at' => null,
        ]);
    }

    public function test_store_creates_new_food_with_invalid_data(): void
    {
        $data = [
          'name' => '',
          'type' => 'invalid_type',
          'image' => 'not_a_file',
          'calories' => -100,
          'pfcfw' => [
            'proteins' => -10,
            'fat' => 'invalid',
            'carbs' => -5,
          ],
          'plan_code' => 'nonexistent_plan',
        ];

        $response = $this->postJson('/api/food', $data, $this->auth_header);

        $response->assertStatus(422);
        $response->assertJson([
          'errors' => [
            'mf_name' => [
              'The mf name field is required.',
            ],
            'mf_type' => [
              'The selected mf type is invalid.',
            ],
            'image' => [
              'The image field must be a file.',
              'The image field must be an image.',
              'The image field must be a file of type: jpeg, png, jpg, gif, webp, avif.',
            ],
            'mf_cals' => [
              'The mf cals field must be at least 0.',
            ],
            'mf_pfcfw.proteins' => [
              'The mf pfcfw.proteins field must be at least 0.',
            ],
            'mf_pfcfw.fat' => [
              'The mf pfcfw.fat field must be a number.',
            ],
            'mf_pfcfw.carbs' => [
              'The mf pfcfw.carbs field must be at least 0.',
            ],
            'mf_pfcfw.fiber' => [
              'The mf pfcfw.fiber field is required.',
            ],
            'mf_pfcfw.water' => [
              'The mf pfcfw.water field is required.',
            ],
            'mf_plan_code' => [
              'The selected mf plan code is invalid.',
            ],
          ],
        ]);
    }

    public function test_store_forbidden_for_non_authorized_roles(): void
    {
        $data = [
          'name' => 'New Food Item',
          'type' => 'food',
          'image_url' => 'https://example.com/new_food.jpg',
          'calories' => 200,
          'pfcfw' => [
            'proteins' => 10,
            'fat' => 5,
            'carbs' => 30,
            'fiber' => 2,
            'water' => 50,
          ],
          'plan_code' => 'mp_bulk',
        ];

        $users = [
          $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->postJson('/api/food', $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
              'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_update_modifies_existing_food(): void
    {
        $food = Food::where('mf_code', '005aaab')->first();

        $data = [
          'name' => 'Updated Avocado Toast',
          'calories' => 260,
          'pfcfw' => [
            'proteins' => 7,
            'fat' => 17,
            'carbs' => 23,
            'fiber' => 8,
            'water' => 10,
          ],
        ];

        $response = $this->patchJson("/api/foods/{$food->mf_code}", $data, $this->auth_header);

        $response->assertStatus(200);
        $response->assertJsonFragment([
          'code' => '005aaab',
          'name' => 'Updated Avocado Toast',
          'calories' => 260,
          'pfcfw' => [
            'proteins' => 7,
            'fat' => 17,
            'carbs' => 23,
            'fiber' => 8,
            'water' => 10,
          ],
        ]);

        $this->assertDatabaseHas('mm_foods', [
          'mf_code' => '005aaab',
          'mf_name' => 'Updated Avocado Toast',
          'mf_cals' => 260,
          'mf_updated_by' => $this->admin_user->mu_code,
          'mf_deleted_at' => null,
        ]);
    }

    public function test_update_forbidden_for_non_authorized_roles(): void
    {
        $food = Food::where('mf_code', '005aaab')->first();
        $data = [
          'name' => 'Updated Avocado Toast',
          'cals' => 260,
        ];

        $users = [
          $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/foods/{$food->mf_code}", $data, $header);

            $response->assertStatus(403);
            $response->assertJson([
              'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_destroy_soft_deletes_food(): void
    {
        $food = Food::where('mf_code', '005aaab')->first();

        $response = $this->deleteJson("/api/foods/{$food->mf_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
          'message' => "Food “{$food->mf_name}” was deleted successfully.",
        ]);

        $this->assertSoftDeleted('mm_foods', [
          'mf_code' => '005aaab',
        ]);
    }

    public function test_destroy_forbidden_for_non_authorized_roles(): void
    {
        $food = Food::where('mf_code', '005aaab')->first();

        $users = [
          $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->deleteJson("/api/foods/{$food->mf_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
              'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_recovers_soft_deleted_food(): void
    {
        $food = Food::where('mf_code', '005aaab')->first();
        $food->delete();

        $response = $this->patchJson("/api/foods/restore/{$food->mf_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
          'message' => "Food “{$food->mf_name}” was restored successfully.",
        ]);

        $this->assertDatabaseHas('mm_foods', [
          'mf_code' => '005aaab',
          'mf_deleted_at' => null,
        ]);
    }

    public function test_restore_forbidden_for_non_admin_or_sub_admin(): void
    {
        $food = Food::where('mf_code', '005aaab')->first();
        $food->delete();

        $users = [
          $this->premium_user,
          $this->regular_user,
        ];

        foreach ($users as $user) {
            $token = JWTAuth::fromUser($user);
            $header = ['Authorization' => 'Bearer ' . $token];
            $response = $this->patchJson("/api/foods/restore/{$food->mf_code}", [], $header);

            $response->assertStatus(403);
            $response->assertJson([
              'error' => 'User does not have the right role.',
            ]);
        }
    }

    public function test_restore_not_found_for_nonexistent_code(): void
    {
        $response = $this->patchJson('/api/foods/restore/nonexistent', [], $this->auth_header);

        $response->assertStatus(404);
        $response->assertJson([
          'message' => 'Food not found.',
        ]);
    }

    public function test_restore_fails_if_food_with_same_name_exists(): void
    {
        $food = Food::where('mf_code', '005aaab')->first();
        $food->delete();

        Food::create([
          'mf_code' => 'another_food',
          'mf_name' => $food->mf_name,
          'mf_type' => 'food',
          'mf_image_url' => 'https://example.com/another_food.jpg',
          'mf_cals' => 200,
          'mf_pfcfw' => [
            'proteins' => 10,
            'fat' => 5,
            'carbs' => 30,
            'fiber' => 2,
            'water' => 50,
          ],
          'mf_created_by' => $this->admin_user->mu_code,
        ]);

        $response = $this->patchJson("/api/foods/restore/{$food->mf_code}", [], $this->auth_header);

        $response->assertStatus(200);
        $response->assertJson([
          'message' => "Food with name “{$food->mf_name}” already exists.",
        ]);

        $this->assertSoftDeleted('mm_foods', [
          'mf_code' => '005aaab',
        ]);
    }
}
