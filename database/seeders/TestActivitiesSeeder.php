<?php

namespace Database\Seeders;

use App\Domain\Models\Activity;
use Illuminate\Database\Seeder;

class TestActivitiesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Activity::firstOrCreate(
            ['ma_name' => 'Running'],
            [
                'ma_code' => 'running',
                'ma_name' => 'Running',
                'ma_cals' => 500,
                'ma_created_at' => '2025-07-22 10:00:00',
                'ma_updated_at' => '2025-07-22 10:00:00',
                'ma_deleted_at' => null,
            ]
        );

        Activity::firstOrCreate(
            ['ma_name' => 'Swimming'],
            [
                'ma_code' => 'swimming',
                'ma_name' => 'Swimming',
                'ma_cals' => 400,
                'ma_created_at' => '2025-07-22 11:00:00',
                'ma_updated_at' => '2025-07-22 11:00:00',
                'ma_deleted_at' => null,
            ]
        );

        Activity::firstOrCreate(
            ['ma_name' => 'Weightlifting'],
            [
                'ma_code' => 'weightlifting',
                'ma_name' => 'Weightlifting',
                'ma_cals' => 300,
                'ma_created_at' => '2025-07-22 12:00:00',
                'ma_updated_at' => '2025-07-22 12:00:00',
                'ma_deleted_at' => null,
            ]
        );
    }
}
