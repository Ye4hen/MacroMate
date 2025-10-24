<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestPlansActivitiesRelationsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $relations = [
            ['mpar_mp' => 1, 'mpar_ma' => 1],
            ['mpar_mp' => 1, 'mpar_ma' => 3],
            ['mpar_mp' => 2, 'mpar_ma' => 2],
            ['mpar_mp' => 3, 'mpar_ma' => 1],
            ['mpar_mp' => 3, 'mpar_ma' => 2],
        ];

        foreach ($relations as $relation) {
            DB::table('mm_plans_activities_relations')->updateOrInsert(
                [
                    'mpar_mp' => $relation['mpar_mp'],
                    'mpar_ma' => $relation['mpar_ma'],
                ],
                []
            );
        }
    }
}
