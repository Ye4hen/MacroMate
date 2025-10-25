<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Domain\Models\User>
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();
        $code = Str::random(10);

        return [
          'mu_code' => $code,
          'mu_name' => $name,
          'mu_email' => $email,
          'mu_password' => Hash::make('password'),
          'mu_role' => 'user',
          'mu_age' => $this->faker->numberBetween(18, 65),
          'mu_height' => $this->faker->numberBetween(150, 200),
          'mu_weight' => $this->faker->numberBetween(55, 100),
          'mu_gender' => $this->faker->randomElement(['male', 'female', 'other']),
          'mu_settings' => [],
          'mu_plan_code' => null,
          'mu_created_at' => now(),
          'mu_updated_at' => now(),
          'mu_deleted_at' => null,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
          'mu_role' => 'admin',
        ]);
    }

    public function subAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
          'mu_role' => 'sub_admin',
        ]);
    }

    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
          'mu_role' => 'premium_user',
        ]);
    }
}
