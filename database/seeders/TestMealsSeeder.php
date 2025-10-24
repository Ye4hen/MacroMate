<?php

namespace Database\Seeders;

use App\Domain\Models\Meal;
use Illuminate\Database\Seeder;

class TestMealsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Meal::firstOrCreate(
            ['mm_code' => '4'],
            [
                'mm_type' => 'Breakfast',
                'mm_user' => 'm3',
                'mm_order' => 1,
                'mm_date' => '2025-07-23',
                'mm_created_at' => '2025-07-23 18:03:44',
                'mm_updated_at' => '2025-07-23 18:53:09',
                'mm_deleted_at' => null,
            ]
        );

        Meal::firstOrCreate(
            ['mm_code' => 'Bl5'],
            [
                'mm_type' => 'Lunch',
                'mm_user' => 'm3',
                'mm_order' => 3,
                'mm_date' => '2025-07-23',
                'mm_created_at' => '2025-07-23 18:18:24',
                'mm_updated_at' => '2025-07-23 19:02:22',
                'mm_deleted_at' => null,
            ]
        );

        Meal::firstOrCreate(
            ['mm_code' => '0Jswg'],
            [
                'mm_type' => 'Breakfast',
                'mm_user' => '0BVEB',
                'mm_order' => 1,
                'mm_date' => '2025-07-22',
                'mm_created_at' => '2025-07-23 20:01:45',
                'mm_updated_at' => '2025-08-02 19:35:36',
                'mm_deleted_at' => null,
            ]
        );

        Meal::firstOrCreate(
            ['mm_code' => '078u2b3'],
            [
                'mm_type' => 'Breakfast',
                'mm_user' => '0BVEB',
                'mm_order' => 1,
                'mm_date' => '2025-02-23',
                'mm_created_at' => '2025-07-23 20:07:25',
                'mm_updated_at' => '2025-08-03 14:30:11',
                'mm_deleted_at' => null,
            ]
        );

        Meal::firstOrCreate(
            ['mm_code' => '00c43SaCI'],
            [
                'mm_type' => 'Dinner',
                'mm_user' => '0BVEB',
                'mm_order' => 5,
                'mm_date' => '2025-07-23',
                'mm_created_at' => '2025-07-23 20:19:05',
                'mm_updated_at' => '2025-07-23 20:19:05',
                'mm_deleted_at' => null,
            ]
        );
    }
}
