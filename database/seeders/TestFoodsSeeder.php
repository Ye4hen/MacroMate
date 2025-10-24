<?php

namespace Database\Seeders;

use App\Domain\Models\Food;
use Illuminate\Database\Seeder;

class TestFoodsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Food::firstOrCreate(
            ['mf_code' => 'H2'],
            [
                'mf_name' => 'Grilled Chicken Breast (original)',
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
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-22 18:39:03',
                'mf_updated_at' => '2025-08-03 12:55:02',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '0nE5E'],
            [
                'mf_name' => 'Grilled Chicken Breast',
                'mf_type' => 'food',
                'mf_image_url' => 'https://www.simplyrecipes.com/thmb/Xm0ZWf_NigGlwZ3f7EFI1JNFAXA=/750x0/filters:no_upscale():max_bytes(150000):strip_icc()/Simply-Recipes-Grilled-Chicken-LEAD-SEO-Vertical-3c66b6ae87184189920ad84f3f1db6bb.jpg',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 165,
                'mf_pfcfw' => [
                    'proteins' => 31,
                    'fat' => 3.6,
                    'carbs' => 0,
                    'fiber' => 0,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-22 19:04:40',
                'mf_updated_at' => '2025-08-03 12:55:06',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '005aaab'],
            [
                'mf_name' => 'Avocado Toast',
                'mf_type' => 'food',
                'mf_image_url' => 'https://www.jessicagavin.com/wp-content/uploads/2020/07/avocado-toast-5.jpg',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 250,
                'mf_pfcfw' => [
                    'proteins' => 6,
                    'fat' => 16,
                    'carbs' => 22,
                    'fiber' => 7,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-22 19:24:11',
                'mf_updated_at' => '2025-08-02 19:24:09',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '002k5tnb7'],
            [
                'mf_name' => 'Greek Yogurt',
                'mf_type' => 'food',
                'mf_image_url' => 'https://media.istockphoto.com/id/154961211/pl/zdj%C4%99cie/pyszne-domowe-kremowy-jogurt.webp?s=2048x2048&w=is&k=20&c=csa8287JGtY_oYC42jhCE4DLHhy7R9LV282bTF-rmEM=',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 100,
                'mf_pfcfw' => [
                    'proteins' => 10,
                    'fat' => 0,
                    'carbs' => 6,
                    'fiber' => 0,
                    'water' => 80,
                ],
                'mf_created_at' => '2025-07-24 19:26:17',
                'mf_updated_at' => '2025-07-24 19:26:17',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '000mil3riNo'],
            [
                'mf_name' => 'Cucumber Slices',
                'mf_type' => 'food',
                'mf_image_url' => 'https://media.istockphoto.com/id/180720295/pl/zdj%C4%99cie/og%C3%B3rki-i-plastry-na-drewnianym-stole.webp?s=2048x2048&w=is&k=20&c=mM1x_MvZGGkwZxNNSt6_995-55zEfNMDq5g8EZ0muuM=',
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
                'mf_created_at' => '2025-07-24 19:26:56',
                'mf_updated_at' => '2025-07-24 19:26:56',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '0000W7takabKn'],
            [
                'mf_name' => 'Vanilla Protein Shake',
                'mf_type' => 'drink',
                'mf_image_url' => 'https://media.istockphoto.com/id/2175043143/pl/zdj%C4%99cie/koktajl-figowy-z-mi%C4%85t%C4%85-i-miodem-podawany-w-s%C5%82oiku-na-bia%C5%82ym-tle-na-drewnianej-desce.webp?s=2048x2048&w=is&k=20&c=Np01q5OtN5jUDiomScTh5WHojaWq967N-sPpWX_KkRs=',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 180,
                'mf_pfcfw' => [
                    'proteins' => 30,
                    'fat' => 2,
                    'carbs' => 12,
                    'fiber' => 1,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-24 19:30:25',
                'mf_updated_at' => '2025-08-03 17:24:51',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '0000TLyC7sP3tsF'],
            [
                'mf_name' => 'Mediterranean Quinoa Bowl',
                'mf_type' => 'food',
                'mf_image_url' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 420,
                'mf_pfcfw' => [
                    'proteins' => 13.5,
                    'fat' => 18.2,
                    'carbs' => 50.1,
                    'fiber' => 8.4,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-24 19:35:00',
                'mf_updated_at' => '2025-07-24 19:35:00',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '000003JhFb4d0TBPq'],
            [
                'mf_name' => 'Chicken & Black Bean Quinoa Bowl',
                'mf_type' => 'food',
                'mf_image_url' => 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 350,
                'mf_pfcfw' => [
                    'proteins' => 22,
                    'fat' => 9,
                    'carbs' => 40,
                    'fiber' => 6,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-24 19:35:21',
                'mf_updated_at' => '2025-07-24 19:35:21',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '00000mT4lgBHw6EZao2'],
            [
                'mf_name' => 'Summer Quinoa & Veggie Bowl',
                'mf_type' => 'food',
                'mf_image_url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 310,
                'mf_pfcfw' => [
                    'proteins' => 12.3,
                    'fat' => 7.8,
                    'carbs' => 45.2,
                    'fiber' => 7,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-24 19:35:45',
                'mf_updated_at' => '2025-07-24 19:35:45',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '000000VfJAa0zivNpiUK5'],
            [
                'mf_name' => 'Greek Quinoa Buddha Bowl',
                'mf_type' => 'food',
                'mf_image_url' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 340,
                'mf_pfcfw' => [
                    'proteins' => 14,
                    'fat' => 11,
                    'carbs' => 42,
                    'fiber' => 8,
                    'water' => 68,
                ],
                'mf_created_at' => '2025-07-24 19:36:19',
                'mf_updated_at' => '2025-07-24 19:36:19',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '0000000FUy9aiAF3ddbE6Ys'],
            [
                'mf_name' => 'Thai Coconut Quinoa Bowl',
                'mf_type' => 'food',
                'mf_image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 460,
                'mf_pfcfw' => [
                    'proteins' => 11,
                    'fat' => 22,
                    'carbs' => 52,
                    'fiber' => 6,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-24 19:36:34',
                'mf_updated_at' => '2025-07-24 19:36:34',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '0000000TyGasF1oqLAtM31dj2'],
            [
                'mf_name' => 'Mediterranean Bowl with Red Peppers & Feta',
                'mf_type' => 'food',
                'mf_image_url' => 'https://images.unsplash.com/photo-1473093226795-af9932fe5856',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 400,
                'mf_pfcfw' => [
                    'proteins' => 13.8,
                    'fat' => 14.5,
                    'carbs' => 48,
                    'fiber' => 7.5,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-24 19:38:15',
                'mf_updated_at' => '2025-07-24 19:38:15',
                'mf_deleted_at' => null,
            ]
        );

        Food::firstOrCreate(
            ['mf_code' => '00000000aFILsgfDi8Q5tXwRv4F'],
            [
                'mf_name' => 'Quinoa & Veggie Protein Bowl',
                'mf_type' => 'food',
                'mf_image_url' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061',
                'mf_image_disk' => 'public',
                'mf_image_variants' => null,
                'mf_cals' => 365,
                'mf_pfcfw' => [
                    'proteins' => 15,
                    'fat' => 10.5,
                    'carbs' => 50,
                    'fiber' => 7.8,
                    'water' => 0,
                ],
                'mf_created_at' => '2025-07-24 19:38:57',
                'mf_updated_at' => '2025-07-24 19:38:57',
                'mf_deleted_at' => null,
            ]
        );
    }
}
