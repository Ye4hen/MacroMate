<?php

namespace Database\Seeders;

use App\Domain\Models\UserRole;
use Illuminate\Database\Seeder;

class TestUserRolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserRole::firstOrCreate(
            ['mur_code' => 'admin'],
            ['mur_name' => 'Admin', 'mur_deleted_at' => null]
        );

        UserRole::firstOrCreate(
            ['mur_code' => 'user'],
            ['mur_name' => 'User', 'mur_deleted_at' => null]
        );

        UserRole::firstOrCreate(
            ['mur_code' => 'sub_admin'],
            ['mur_name' => 'Sub Admin', 'mur_deleted_at' => null]
        );

        UserRole::firstOrCreate(
            ['mur_code' => 'premium_user'],
            ['mur_name' => 'Premium User', 'mur_deleted_at' => null]
        );
    }
}
