<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestMealsFoodsRelationsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $relations = [
            ['mmfr_mm' => '1', 'mmfr_mf' => '3', 'mmfr_quantity' => 120, 'mmfr_unit' => 'g'],
            ['mmfr_mm' => '1', 'mmfr_mf' => '4', 'mmfr_quantity' => 150, 'mmfr_unit' => 'g'],
            ['mmfr_mm' => '2', 'mmfr_mf' => '3', 'mmfr_quantity' => 150, 'mmfr_unit' => 'g'],
            ['mmfr_mm' => '3', 'mmfr_mf' => '3', 'mmfr_quantity' => 200, 'mmfr_unit' => 'g'],
            ['mmfr_mm' => '4', 'mmfr_mf' => '4', 'mmfr_quantity' => 200, 'mmfr_unit' => 'g'],
            ['mmfr_mm' => '5', 'mmfr_mf' => '4', 'mmfr_quantity' => 200, 'mmfr_unit' => 'g'],
        ];

        foreach ($relations as $relation) {
            DB::table('mm_meals_foods_relations')->updateOrInsert(
                [
                    'mmfr_mm' => $relation['mmfr_mm'],
                    'mmfr_mf' => $relation['mmfr_mf'],
                ],
                [
                    'mmfr_quantity' => $relation['mmfr_quantity'],
                    'mmfr_unit' => $relation['mmfr_unit'],
                ]
            );
        }
    }
}
