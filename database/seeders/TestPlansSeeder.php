<?php

namespace Database\Seeders;

use App\Domain\Models\Plan;
use Illuminate\Database\Seeder;

class TestPlansSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Plan::firstOrCreate(
            ['mp_code' => 'mp_bulk'],
            [
                'mp_name' => 'Bulk',
                'mp_cal_index' => 1.15,
                'mp_pfc' => [
                    'proteins' => 40,
                    'fat' => 20,
                    'carbs' => 40,
                    'fiber' => 30,
                    'water' => 3000,
                ],
                'mp_deleted_at' => null,
            ]
        );

        Plan::firstOrCreate(
            ['mp_code' => 'mp_maintenance'],
            [
                'mp_name' => 'Maintenance',
                'mp_cal_index' => 1,
                'mp_pfc' => [
                    'proteins' => 30,
                    'fat' => 20,
                    'carbs' => 50,
                    'fiber' => 30,
                    'water' => 2500,
                ],
                'mp_deleted_at' => null,
            ]
        );

        Plan::firstOrCreate(
            ['mp_code' => 'mp_cut'],
            [
                'mp_name' => 'Cut',
                'mp_cal_index' => 0.85,
                'mp_pfc' => [
                    'proteins' => 55,
                    'fat' => 15,
                    'carbs' => 30,
                    'fiber' => 35,
                    'water' => 2500,
                ],
                'mp_deleted_at' => null,
            ]
        );
    }
}
