<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * The model that the factory creates.
     *
     * @var class-string<\App\Domain\Models\Food>
     */
    protected $model = Food::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'mf_code' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
          'mf_name' => $this->faker->words(2, true),
          'mf_type' => 'food',
          'mf_image_url' => null,
          'mf_image_disk' => 'public',
          'mf_image_variants' => null,
          'mf_cals' => $this->faker->numberBetween(50, 800),
          'mf_pfcfw' => [
            'proteins' => $this->faker->randomFloat(1, 0, 100),
            'fat' => $this->faker->randomFloat(1, 0, 100),
            'carbs' => $this->faker->randomFloat(1, 0, 200),
            'fiber' => $this->faker->randomFloat(1, 0, 50),
            'water' => $this->faker->randomFloat(1, 0, 4000),
          ],
          'mf_plan_code' => null,
          'mf_created_by' => null,
          'mf_updated_by' => null,
          'mf_deleted_at' => null,
        ];
    }
}
