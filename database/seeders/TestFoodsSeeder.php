<?php

namespace Database\Seeders;

use App\Domain\Models\Food;
use Illuminate\Database\Seeder;

class Foods100Seeder extends Seeder
{
    /**
     * Seed the application's database with ~100 single-ingredient foods & drinks.
     */
    public function run(): void
    {
        // Timestamp used for created_at / updated_at
        $ts = '2025-12-16 12:00:00';

        Food::firstOrCreate(['mf_code' => 'F001'], [
            'mf_name' => 'Apple',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 52,
            'mf_pfcfw' => [
                'proteins' => 0.3,
                'fat' => 0.2,
                'carbs' => 14,
                'fiber' => 2.4,
                'water' => 85.6,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F002'], [
            'mf_name' => 'Banana',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 89,
            'mf_pfcfw' => [
                'proteins' => 1.1,
                'fat' => 0.3,
                'carbs' => 23,
                'fiber' => 2.6,
                'water' => 74.9,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F003'], [
            'mf_name' => 'Orange',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 47,
            'mf_pfcfw' => [
                'proteins' => 0.9,
                'fat' => 0.1,
                'carbs' => 12,
                'fiber' => 2.4,
                'water' => 86.8,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F004'], [
            'mf_name' => 'Strawberry',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 33,
            'mf_pfcfw' => [
                'proteins' => 0.7,
                'fat' => 0.3,
                'carbs' => 8,
                'fiber' => 2,
                'water' => 91.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F005'], [
            'mf_name' => 'Blueberries',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 57,
            'mf_pfcfw' => [
                'proteins' => 0.7,
                'fat' => 0.3,
                'carbs' => 14,
                'fiber' => 2.4,
                'water' => 84.2,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F006'], [
            'mf_name' => 'Grapes',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 69,
            'mf_pfcfw' => [
                'proteins' => 0.6,
                'fat' => 0.4,
                'carbs' => 18,
                'fiber' => 0.9,
                'water' => 80.5,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F007'], [
            'mf_name' => 'Pear',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 57,
            'mf_pfcfw' => [
                'proteins' => 0.4,
                'fat' => 0.1,
                'carbs' => 15,
                'fiber' => 3.1,
                'water' => 84.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F008'], [
            'mf_name' => 'Peach',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 39,
            'mf_pfcfw' => [
                'proteins' => 0.9,
                'fat' => 0.3,
                'carbs' => 10,
                'fiber' => 1.5,
                'water' => 89.5,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F009'], [
            'mf_name' => 'Mango',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 60,
            'mf_pfcfw' => [
                'proteins' => 0.8,
                'fat' => 0.4,
                'carbs' => 15,
                'fiber' => 1.6,
                'water' => 83.5,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F010'], [
            'mf_name' => 'Pineapple',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 50,
            'mf_pfcfw' => [
                'proteins' => 0.5,
                'fat' => 0.1,
                'carbs' => 13,
                'fiber' => 1.4,
                'water' => 86.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F011'], [
            'mf_name' => 'Watermelon',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 30,
            'mf_pfcfw' => [
                'proteins' => 0.6,
                'fat' => 0.2,
                'carbs' => 8,
                'fiber' => 0.4,
                'water' => 91.5,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F012'], [
            'mf_name' => 'Avocado',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 160,
            'mf_pfcfw' => [
                'proteins' => 2.0,
                'fat' => 15.0,
                'carbs' => 9.0,
                'fiber' => 7.0,
                'water' => 73.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F013'], [
            'mf_name' => 'Tomato',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 18,
            'mf_pfcfw' => [
                'proteins' => 0.9,
                'fat' => 0.2,
                'carbs' => 3.9,
                'fiber' => 1.2,
                'water' => 95.2,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F014'], [
            'mf_name' => 'Cucumber',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 16,
            'mf_pfcfw' => [
                'proteins' => 0.7,
                'fat' => 0.1,
                'carbs' => 3.6,
                'fiber' => 0.5,
                'water' => 95.2,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F015'], [
            'mf_name' => 'Lettuce',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 15,
            'mf_pfcfw' => [
                'proteins' => 1.4,
                'fat' => 0.2,
                'carbs' => 2.9,
                'fiber' => 1.3,
                'water' => 95.6,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F016'], [
            'mf_name' => 'Spinach',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 23,
            'mf_pfcfw' => [
                'proteins' => 2.9,
                'fat' => 0.4,
                'carbs' => 3.6,
                'fiber' => 2.2,
                'water' => 91.4,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F017'], [
            'mf_name' => 'Kale',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 49,
            'mf_pfcfw' => [
                'proteins' => 4.3,
                'fat' => 0.9,
                'carbs' => 8.8,
                'fiber' => 3.6,
                'water' => 84.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F018'], [
            'mf_name' => 'Broccoli',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 34,
            'mf_pfcfw' => [
                'proteins' => 2.8,
                'fat' => 0.4,
                'carbs' => 7.0,
                'fiber' => 2.6,
                'water' => 89.3,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F019'], [
            'mf_name' => 'Cauliflower',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 25,
            'mf_pfcfw' => [
                'proteins' => 1.9,
                'fat' => 0.3,
                'carbs' => 5.0,
                'fiber' => 2.0,
                'water' => 92.1,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F020'], [
            'mf_name' => 'Carrot',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 41,
            'mf_pfcfw' => [
                'proteins' => 0.9,
                'fat' => 0.2,
                'carbs' => 10,
                'fiber' => 2.8,
                'water' => 88.3,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F021'], [
            'mf_name' => 'Potato',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 77,
            'mf_pfcfw' => [
                'proteins' => 2.0,
                'fat' => 0.1,
                'carbs' => 17,
                'fiber' => 2.2,
                'water' => 79.3,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F022'], [
            'mf_name' => 'Sweet Potato',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 86,
            'mf_pfcfw' => [
                'proteins' => 1.6,
                'fat' => 0.1,
                'carbs' => 20,
                'fiber' => 3.0,
                'water' => 77.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F023'], [
            'mf_name' => 'Beetroot',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 43,
            'mf_pfcfw' => [
                'proteins' => 1.6,
                'fat' => 0.2,
                'carbs' => 10,
                'fiber' => 2.8,
                'water' => 87.6,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F024'], [
            'mf_name' => 'Onion',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 40,
            'mf_pfcfw' => [
                'proteins' => 1.1,
                'fat' => 0.1,
                'carbs' => 9.3,
                'fiber' => 1.7,
                'water' => 89.1,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F025'], [
            'mf_name' => 'Garlic',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 149,
            'mf_pfcfw' => [
                'proteins' => 6.4,
                'fat' => 0.5,
                'carbs' => 33,
                'fiber' => 2.1,
                'water' => 58.6,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F026'], [
            'mf_name' => 'Bell Pepper',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 31,
            'mf_pfcfw' => [
                'proteins' => 1.0,
                'fat' => 0.3,
                'carbs' => 6.0,
                'fiber' => 2.1,
                'water' => 92.2,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F027'], [
            'mf_name' => 'Zucchini',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 17,
            'mf_pfcfw' => [
                'proteins' => 1.2,
                'fat' => 0.3,
                'carbs' => 3.1,
                'fiber' => 1.0,
                'water' => 94.2,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F028'], [
            'mf_name' => 'Egg (whole)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 155,
            'mf_pfcfw' => [
                'proteins' => 13.0,
                'fat' => 11.0,
                'carbs' => 1.1,
                'fiber' => 0,
                'water' => 75.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F029'], [
            'mf_name' => 'Egg White',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 52,
            'mf_pfcfw' => [
                'proteins' => 11.0,
                'fat' => 0.2,
                'carbs' => 0.7,
                'fiber' => 0,
                'water' => 86.6,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F030'], [
            'mf_name' => 'Chicken Breast (raw)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 165,
            'mf_pfcfw' => [
                'proteins' => 31.0,
                'fat' => 3.6,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 65.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F031'], [
            'mf_name' => 'Chicken Thigh',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 209,
            'mf_pfcfw' => [
                'proteins' => 17.5,
                'fat' => 15.5,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 60.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F032'], [
            'mf_name' => 'Turkey Breast',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 135,
            'mf_pfcfw' => [
                'proteins' => 29.0,
                'fat' => 1.2,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 64.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F033'], [
            'mf_name' => 'Beef (sirloin)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 250,
            'mf_pfcfw' => [
                'proteins' => 26.0,
                'fat' => 15.0,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 60.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F034'], [
            'mf_name' => 'Ground Beef (85% lean)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 250,
            'mf_pfcfw' => [
                'proteins' => 26.0,
                'fat' => 17.0,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 58.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F035'], [
            'mf_name' => 'Pork Chop',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 242,
            'mf_pfcfw' => [
                'proteins' => 27.0,
                'fat' => 14.0,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 58.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F036'], [
            'mf_name' => 'Salmon (fillet)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 208,
            'mf_pfcfw' => [
                'proteins' => 20.0,
                'fat' => 13.0,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 64.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F037'], [
            'mf_name' => 'Tuna (canned in water)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 116,
            'mf_pfcfw' => [
                'proteins' => 26.0,
                'fat' => 0.8,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 65.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F038'], [
            'mf_name' => 'Cod',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 82,
            'mf_pfcfw' => [
                'proteins' => 18.0,
                'fat' => 0.7,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 75.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F039'], [
            'mf_name' => 'Shrimp',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 99,
            'mf_pfcfw' => [
                'proteins' => 24.0,
                'fat' => 0.3,
                'carbs' => 0.2,
                'fiber' => 0,
                'water' => 75.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F040'], [
            'mf_name' => 'Sardines (canned in oil)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 208,
            'mf_pfcfw' => [
                'proteins' => 25.0,
                'fat' => 11.5,
                'carbs' => 0.0,
                'fiber' => 0,
                'water' => 60.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F041'], [
            'mf_name' => 'Tofu',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 76,
            'mf_pfcfw' => [
                'proteins' => 8.0,
                'fat' => 4.8,
                'carbs' => 1.9,
                'fiber' => 0.3,
                'water' => 82.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F042'], [
            'mf_name' => 'Tempeh',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 193,
            'mf_pfcfw' => [
                'proteins' => 20.0,
                'fat' => 11.0,
                'carbs' => 9.0,
                'fiber' => 5.4,
                'water' => 60.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F043'], [
            'mf_name' => 'Lentils (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 116,
            'mf_pfcfw' => [
                'proteins' => 9.0,
                'fat' => 0.4,
                'carbs' => 20.0,
                'fiber' => 8.0,
                'water' => 70.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F044'], [
            'mf_name' => 'Chickpeas (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 164,
            'mf_pfcfw' => [
                'proteins' => 8.9,
                'fat' => 2.6,
                'carbs' => 27.4,
                'fiber' => 7.6,
                'water' => 60.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F045'], [
            'mf_name' => 'Black Beans (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 132,
            'mf_pfcfw' => [
                'proteins' => 8.9,
                'fat' => 0.5,
                'carbs' => 23.7,
                'fiber' => 8.7,
                'water' => 70.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F046'], [
            'mf_name' => 'Kidney Beans (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 127,
            'mf_pfcfw' => [
                'proteins' => 8.7,
                'fat' => 0.5,
                'carbs' => 22.8,
                'fiber' => 6.4,
                'water' => 68.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F047'], [
            'mf_name' => 'Cannellini Beans (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 139,
            'mf_pfcfw' => [
                'proteins' => 8.1,
                'fat' => 1.3,
                'carbs' => 24.0,
                'fiber' => 7.4,
                'water' => 66.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F048'], [
            'mf_name' => 'Quinoa (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 120,
            'mf_pfcfw' => [
                'proteins' => 4.4,
                'fat' => 1.9,
                'carbs' => 21.3,
                'fiber' => 2.8,
                'water' => 72.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F049'], [
            'mf_name' => 'Brown Rice (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 123,
            'mf_pfcfw' => [
                'proteins' => 2.7,
                'fat' => 1.0,
                'carbs' => 25.6,
                'fiber' => 1.6,
                'water' => 70.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F050'], [
            'mf_name' => 'White Rice (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 130,
            'mf_pfcfw' => [
                'proteins' => 2.4,
                'fat' => 0.3,
                'carbs' => 28.2,
                'fiber' => 0.4,
                'water' => 68.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F051'], [
            'mf_name' => 'Rolled Oats (dry)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 389,
            'mf_pfcfw' => [
                'proteins' => 16.9,
                'fat' => 6.9,
                'carbs' => 66.3,
                'fiber' => 10.6,
                'water' => 8.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F052'], [
            'mf_name' => 'Whole Wheat Bread (per 100g)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 247,
            'mf_pfcfw' => [
                'proteins' => 13.0,
                'fat' => 4.2,
                'carbs' => 41.0,
                'fiber' => 7.0,
                'water' => 35.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F053'], [
            'mf_name' => 'White Bread (per 100g)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 265,
            'mf_pfcfw' => [
                'proteins' => 9.0,
                'fat' => 3.2,
                'carbs' => 49.0,
                'fiber' => 2.7,
                'water' => 35.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F054'], [
            'mf_name' => 'Pasta (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 131,
            'mf_pfcfw' => [
                'proteins' => 5.0,
                'fat' => 1.1,
                'carbs' => 25.0,
                'fiber' => 1.3,
                'water' => 60.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F055'], [
            'mf_name' => 'Corn (boiled)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 96,
            'mf_pfcfw' => [
                'proteins' => 3.4,
                'fat' => 1.5,
                'carbs' => 21.0,
                'fiber' => 2.4,
                'water' => 68.3,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F056'], [
            'mf_name' => 'Green Peas (cooked)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 81,
            'mf_pfcfw' => [
                'proteins' => 5.0,
                'fat' => 0.4,
                'carbs' => 14.0,
                'fiber' => 5.5,
                'water' => 79.3,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F057'], [
            'mf_name' => 'Almonds',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 579,
            'mf_pfcfw' => [
                'proteins' => 21.2,
                'fat' => 49.9,
                'carbs' => 21.6,
                'fiber' => 12.5,
                'water' => 4.4,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F058'], [
            'mf_name' => 'Walnuts',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 654,
            'mf_pfcfw' => [
                'proteins' => 15.2,
                'fat' => 65.2,
                'carbs' => 13.7,
                'fiber' => 6.7,
                'water' => 4.1,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F059'], [
            'mf_name' => 'Cashews',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 553,
            'mf_pfcfw' => [
                'proteins' => 18.2,
                'fat' => 43.9,
                'carbs' => 30.2,
                'fiber' => 3.3,
                'water' => 5.2,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F060'], [
            'mf_name' => 'Peanuts',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 567,
            'mf_pfcfw' => [
                'proteins' => 25.8,
                'fat' => 49.2,
                'carbs' => 16.1,
                'fiber' => 8.5,
                'water' => 2.6,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F061'], [
            'mf_name' => 'Peanut Butter',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 588,
            'mf_pfcfw' => [
                'proteins' => 25.0,
                'fat' => 50.0,
                'carbs' => 20.0,
                'fiber' => 6.0,
                'water' => 2.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F062'], [
            'mf_name' => 'Sunflower Seeds',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 584,
            'mf_pfcfw' => [
                'proteins' => 20.8,
                'fat' => 51.5,
                'carbs' => 20.0,
                'fiber' => 8.6,
                'water' => 4.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F063'], [
            'mf_name' => 'Chia Seeds',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 486,
            'mf_pfcfw' => [
                'proteins' => 16.5,
                'fat' => 30.7,
                'carbs' => 42.1,
                'fiber' => 34.4,
                'water' => 6.7,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F064'], [
            'mf_name' => 'Flaxseed',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 534,
            'mf_pfcfw' => [
                'proteins' => 18.3,
                'fat' => 42.2,
                'carbs' => 28.9,
                'fiber' => 27.3,
                'water' => 6.9,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F065'], [
            'mf_name' => 'Olive Oil',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 884,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 100.0,
                'carbs' => 0.0,
                'fiber' => 0.0,
                'water' => 0.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F066'], [
            'mf_name' => 'Butter',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 717,
            'mf_pfcfw' => [
                'proteins' => 0.9,
                'fat' => 81.0,
                'carbs' => 0.1,
                'fiber' => 0.0,
                'water' => 16.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F067'], [
            'mf_name' => 'Margarine',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 717,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 80.0,
                'carbs' => 0.0,
                'fiber' => 0.0,
                'water' => 16.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F068'], [
            'mf_name' => 'Yogurt (plain, whole)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 61,
            'mf_pfcfw' => [
                'proteins' => 3.5,
                'fat' => 3.3,
                'carbs' => 4.7,
                'fiber' => 0.0,
                'water' => 85.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F069'], [
            'mf_name' => 'Kefir',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 59,
            'mf_pfcfw' => [
                'proteins' => 3.3,
                'fat' => 1.5,
                'carbs' => 4.2,
                'fiber' => 0.0,
                'water' => 89.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F070'], [
            'mf_name' => 'Cheddar Cheese',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 403,
            'mf_pfcfw' => [
                'proteins' => 24.9,
                'fat' => 33.1,
                'carbs' => 1.3,
                'fiber' => 0.0,
                'water' => 37.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F071'], [
            'mf_name' => 'Mozzarella',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 280,
            'mf_pfcfw' => [
                'proteins' => 28.0,
                'fat' => 17.0,
                'carbs' => 3.1,
                'fiber' => 0.0,
                'water' => 45.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F072'], [
            'mf_name' => 'Cottage Cheese',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 98,
            'mf_pfcfw' => [
                'proteins' => 11.1,
                'fat' => 4.3,
                'carbs' => 3.4,
                'fiber' => 0.0,
                'water' => 79.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F073'], [
            'mf_name' => 'Milk (whole)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 60,
            'mf_pfcfw' => [
                'proteins' => 3.3,
                'fat' => 3.6,
                'carbs' => 4.8,
                'fiber' => 0.0,
                'water' => 87.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F074'], [
            'mf_name' => 'Milk (skim)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 34,
            'mf_pfcfw' => [
                'proteins' => 3.4,
                'fat' => 0.1,
                'carbs' => 5.0,
                'fiber' => 0.0,
                'water' => 91.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F075'], [
            'mf_name' => 'Soy Milk',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 33,
            'mf_pfcfw' => [
                'proteins' => 3.3,
                'fat' => 1.6,
                'carbs' => 0.6,
                'fiber' => 0.0,
                'water' => 88.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F076'], [
            'mf_name' => 'Almond Milk (unsweetened)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 15,
            'mf_pfcfw' => [
                'proteins' => 0.6,
                'fat' => 1.1,
                'carbs' => 0.3,
                'fiber' => 0.0,
                'water' => 95.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F077'], [
            'mf_name' => 'Black Coffee (brewed)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 1,
            'mf_pfcfw' => [
                'proteins' => 0.1,
                'fat' => 0.0,
                'carbs' => 0.0,
                'fiber' => 0.0,
                'water' => 99.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F078'], [
            'mf_name' => 'Green Tea',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 1,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 0.0,
                'carbs' => 0.0,
                'fiber' => 0.0,
                'water' => 99.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F079'], [
            'mf_name' => 'Herbal Tea',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 1,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 0.0,
                'carbs' => 0.0,
                'fiber' => 0.0,
                'water' => 99.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F080'], [
            'mf_name' => 'Orange Juice (unsweetened)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 45,
            'mf_pfcfw' => [
                'proteins' => 0.7,
                'fat' => 0.2,
                'carbs' => 10.4,
                'fiber' => 0.2,
                'water' => 88.7,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F081'], [
            'mf_name' => 'Apple Juice',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 46,
            'mf_pfcfw' => [
                'proteins' => 0.1,
                'fat' => 0.1,
                'carbs' => 11.3,
                'fiber' => 0.0,
                'water' => 88.3,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F082'], [
            'mf_name' => 'Cola (regular)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 140,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 0.0,
                'carbs' => 39.0,
                'fiber' => 0.0,
                'water' => 0.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F083'], [
            'mf_name' => 'Lemonade (homemade)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 29,
            'mf_pfcfw' => [
                'proteins' => 0.4,
                'fat' => 0.0,
                'carbs' => 7.9,
                'fiber' => 0.0,
                'water' => 91.3,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F084'], [
            'mf_name' => 'Beer (lager)',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 43,
            'mf_pfcfw' => [
                'proteins' => 0.5,
                'fat' => 0.0,
                'carbs' => 3.6,
                'fiber' => 0.0,
                'water' => 92.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F085'], [
            'mf_name' => 'Red Wine',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 85,
            'mf_pfcfw' => [
                'proteins' => 0.1,
                'fat' => 0.0,
                'carbs' => 2.6,
                'fiber' => 0.0,
                'water' => 85.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F086'], [
            'mf_name' => 'White Wine',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 82,
            'mf_pfcfw' => [
                'proteins' => 0.1,
                'fat' => 0.0,
                'carbs' => 2.6,
                'fiber' => 0.0,
                'water' => 85.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F087'], [
            'mf_name' => 'Sparkling Water',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 0,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 0.0,
                'carbs' => 0.0,
                'fiber' => 0.0,
                'water' => 100.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F088'], [
            'mf_name' => 'Still Water',
            'mf_type' => 'drink',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 0,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 0.0,
                'carbs' => 0.0,
                'fiber' => 0.0,
                'water' => 100.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F089'], [
            'mf_name' => 'Honey',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 304,
            'mf_pfcfw' => [
                'proteins' => 0.3,
                'fat' => 0.0,
                'carbs' => 82.0,
                'fiber' => 0.2,
                'water' => 17.1,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F090'], [
            'mf_name' => 'Sugar (granulated)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 387,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 0.0,
                'carbs' => 100.0,
                'fiber' => 0.0,
                'water' => 0.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F091'], [
            'mf_name' => 'Maple Syrup',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 260,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 0.0,
                'carbs' => 67.0,
                'fiber' => 0.0,
                'water' => 32.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F092'], [
            'mf_name' => 'Dark Chocolate (70%)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 598,
            'mf_pfcfw' => [
                'proteins' => 7.8,
                'fat' => 42.6,
                'carbs' => 46.4,
                'fiber' => 11.0,
                'water' => 1.2,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F093'], [
            'mf_name' => 'Ice Cream (vanilla)',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 207,
            'mf_pfcfw' => [
                'proteins' => 3.5,
                'fat' => 11.0,
                'carbs' => 23.0,
                'fiber' => 0.5,
                'water' => 61.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F094'], [
            'mf_name' => 'Potato Chips',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 536,
            'mf_pfcfw' => [
                'proteins' => 7.0,
                'fat' => 34.0,
                'carbs' => 51.0,
                'fiber' => 3.8,
                'water' => 1.5,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F095'], [
            'mf_name' => 'Corn Tortilla',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 218,
            'mf_pfcfw' => [
                'proteins' => 6.6,
                'fat' => 6.9,
                'carbs' => 36.2,
                'fiber' => 8.3,
                'water' => 39.5,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F096'], [
            'mf_name' => 'Hummus',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 166,
            'mf_pfcfw' => [
                'proteins' => 7.9,
                'fat' => 9.6,
                'carbs' => 14.3,
                'fiber' => 6.0,
                'water' => 55.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F097'], [
            'mf_name' => 'Soy Sauce',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 53,
            'mf_pfcfw' => [
                'proteins' => 8.0,
                'fat' => 0.6,
                'carbs' => 4.9,
                'fiber' => 0.0,
                'water' => 40.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F098'], [
            'mf_name' => 'Ketchup',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 112,
            'mf_pfcfw' => [
                'proteins' => 1.3,
                'fat' => 0.3,
                'carbs' => 26.0,
                'fiber' => 1.3,
                'water' => 32.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F099'], [
            'mf_name' => 'Mustard',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 66,
            'mf_pfcfw' => [
                'proteins' => 4.4,
                'fat' => 4.5,
                'carbs' => 5.1,
                'fiber' => 3.3,
                'water' => 64.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        Food::firstOrCreate(['mf_code' => 'F100'], [
            'mf_name' => 'Mayonnaise',
            'mf_type' => 'food',
            'mf_image_url' => null,
            'mf_image_disk' => 'public',
            'mf_image_variants' => null,
            'mf_cals' => 680,
            'mf_pfcfw' => [
                'proteins' => 0.0,
                'fat' => 75.0,
                'carbs' => 0.6,
                'fiber' => 0.0,
                'water' => 15.0,
            ],
            'mf_created_at' => $ts,
            'mf_updated_at' => $ts,
            'mf_deleted_at' => null,
        ]);

        // === Chicken Breast ===
        Food::firstOrCreate(
            ['mf_code' => 'CH_BOILED'],
            [
                'mf_name' => 'Chicken Breast (Boiled)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 165,
                'mf_pfcfw' => [
                    'proteins' => 31,
                    'fat' => 3.6,
                    'carbs' => 0,
                    'fiber' => 0,
                    'water' => 65,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => 'CH_PAN_FRIED'],
            [
                'mf_name' => 'Chicken Breast (Pan-Fried)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 195,
                'mf_pfcfw' => [
                    'proteins' => 30,
                    'fat' => 6.5,
                    'carbs' => 0,
                    'fiber' => 0,
                    'water' => 60,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => 'CH_DEEP_FRIED'],
            [
                'mf_name' => 'Chicken Breast (Deep-Fried)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 240,
                'mf_pfcfw' => [
                    'proteins' => 27,
                    'fat' => 12,
                    'carbs' => 0,
                    'fiber' => 0,
                    'water' => 55,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );

        // === Eggs ===
        Food::firstOrCreate(
            ['mf_code' => 'EG_RAW'],
            [
                'mf_name' => 'Egg (Raw)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 155,
                'mf_pfcfw' => [
                    'proteins' => 13,
                    'fat' => 11,
                    'carbs' => 1.1,
                    'fiber' => 0,
                    'water' => 76,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => 'EG_BOILED'],
            [
                'mf_name' => 'Egg (Boiled)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 155,
                'mf_pfcfw' => [
                    'proteins' => 13,
                    'fat' => 11,
                    'carbs' => 1.1,
                    'fiber' => 0,
                    'water' => 75,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => 'EG_FRIED'],
            [
                'mf_name' => 'Egg (Fried)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 196,
                'mf_pfcfw' => [
                    'proteins' => 13,
                    'fat' => 15,
                    'carbs' => 1.1,
                    'fiber' => 0,
                    'water' => 70,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => 'EG_SCRAMBLED'],
            [
                'mf_name' => 'Egg (Scrambled)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 166,
                'mf_pfcfw' => [
                    'proteins' => 12.5,
                    'fat' => 12,
                    'carbs' => 1.3,
                    'fiber' => 0,
                    'water' => 72,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => 'EG_POACHED'],
            [
                'mf_name' => 'Egg (Poached)',
                'mf_type' => 'food',
                'mf_image_url' => null,
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 143,
                'mf_pfcfw' => [
                    'proteins' => 13,
                    'fat' => 9.5,
                    'carbs' => 1.1,
                    'fiber' => 0,
                    'water' => 78,
                ],
                'mf_created_at' => now(),
                'mf_updated_at' => now(),
                'mf_deleted_at' => null,
            ]
        );
    }
}
