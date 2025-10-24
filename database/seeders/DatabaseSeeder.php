<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
          TestPlansSeeder::class,
          TestActivitiesSeeder::class,
          TestFoodsSeeder::class,
          TestPlansActivitiesRelationsSeeder::class,
          TestUserRolesSeeder::class,
          TestUsersSeeder::class,
          TestMealsSeeder::class,
          TestMealsFoodsRelationsSeeder::class,
        ]);
    }
}
