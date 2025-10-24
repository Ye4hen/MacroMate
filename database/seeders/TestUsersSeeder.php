<?php

namespace Database\Seeders;

use App\Domain\Models\User;
use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['mu_code' => 'm3'],
            [
                'mu_name' => 'Bob',
                'mu_email' => 'bob1488@gmail.com',
                'mu_password' => '$2y$12$OYYRO/UcNmo2YL/5MIxZIugy9v.tud6V0OXPlDjWnt.f/hy3O.6jy',
                'mu_role' => 'admin',
                'mu_created_at' => '2025-07-22 17:15:03',
                'mu_updated_at' => '2025-07-22 19:23:31',
                'mu_deleted_at' => null,
            ]
        );

        User::firstOrCreate(
            ['mu_code' => '0BVEB'],
            [
                'mu_name' => 'Adolf Hitler',
                'mu_email' => 'hitler1889@gmail.com',
                'mu_password' => '$2y$12$ak3OxavIsl95/ZjthiJfx.Ygr53EjiCMKUf.3RO5huIfXY3Tv9Bt6',
                'mu_role' => 'premium_user',
                'mu_created_at' => '2025-07-23 19:50:20',
                'mu_updated_at' => '2025-08-10 19:01:04',
                'mu_deleted_at' => null,
            ]
        );

        User::firstOrCreate(
            ['mu_code' => 'UBuVYLSw7'],
            [
                'mu_name' => 'Test User',
                'mu_email' => 'test@example.com',
                'mu_password' => '$2y$12$0b36I10/ufYxMBwRrs9/H0dhukkBX48VC/W6JqeJGLF1jXx0CIo5IAeK',
                'mu_role' => 'user',
                'mu_age' => 25,
                'mu_height' => 196,
                'mu_weight' => 52,
                'mu_gender' => 'female',
                'mu_settings' => '[]',
                'mu_created_at' => '2025-08-10 17:26:33',
                'mu_updated_at' => '2025-08-10 17:26:33',
                'mu_deleted_at' => null,
            ]
        );
    }
}
