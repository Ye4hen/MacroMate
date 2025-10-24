<?php

namespace Tests\Feature\Jobs;

use App\Domain\Models\Food;
use App\Jobs\ProcessFoodImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Tests\TestCase;

class ProcessFoodImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_variants_and_updates_db(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('food.jpg', 1200, 800)->size(1200);
        $path = $file->storeAs('foods/' . date('Y/m'), 'test.jpg', 'public');

        $disk = Storage::disk('public');

        $this->assertTrue($disk->exists($path), "Uploaded file {$path} not found on disk 'public'");

        $food = Food::factory()->create([
          'mf_image_url' => $path,
          'mf_image_disk' => 'public',
        ]);

        $manager = ImageManager::gd();
        $job = new ProcessFoodImage($food, $path, 'public', $manager);

        $job->handle();

        $base_folder = rtrim(pathinfo($path, PATHINFO_DIRNAME), '/') . '/' . ($food->mf_id ?? 'unknown') . '/';

        $files = Storage::disk('public')->allFiles($base_folder);

        $this->assertNotEmpty($files, 'No variant files were generated');

        $has_jpeg = collect($files)->first(fn ($f) => preg_match('#/w\d+_.*\.jpg$#', $f));
        $has_webp = collect($files)->first(fn ($f) => preg_match('#/w\d+_.*\.webp$#', $f));
        $has_avif = collect($files)->first(fn ($f) => preg_match('#/w\d+_.*\.avif$#', $f));
        $has_thumb = collect($files)->first(fn ($f) => str_contains($f, 'thumb_'));

        $this->assertNotFalse($has_jpeg, 'No JPEG variants found');
        $this->assertNotFalse($has_webp, 'No WEBP variants found');
        $this->assertNotFalse($has_avif, 'No Avif variants found');
        $this->assertNotFalse($has_thumb, 'No thumbnail found');

        $this->assertFalse(Storage::disk('public')->exists($path), 'Original upload still exists but expected deleted');

        $fresh = $food->fresh();
        $variants = $fresh->mf_image_variants ?? null;

        $this->assertIsArray($variants, 'mf_image_variants is not an array');
        $this->assertArrayHasKey('original', $variants, 'mf_image_variants.original missing');
        $this->assertArrayHasKey('jpeg', $variants, 'mf_image_variants.jpeg missing');
        $this->assertArrayHasKey('webp', $variants, 'mf_image_variants.webp missing');
        $this->assertArrayHasKey('avif', $variants, 'mf_image_variants.avif missing');
        $this->assertArrayHasKey('thumbnail', $variants, 'mf_image_variants.thumbnail missing');

        $jpeg_entries = $variants['jpeg'] ?? [];
        $webp_entries = $variants['webp'] ?? [];
        $avif_entries = $variants['avif'] ?? [];
        $entries = array_merge($jpeg_entries, $webp_entries, $avif_entries);
        $this->assertNotEmpty($jpeg_entries, 'No jpeg entries in variants');
        $this->assertNotEmpty($webp_entries, 'No webp entries in variants');
        $this->assertNotEmpty($avif_entries, 'No avif entries in variants');

        foreach ($entries as $entry_path) {
            $this->assertTrue(Storage::disk('public')->exists($entry_path), "Variant file {$entry_path} does not exist");
        }
    }

    public function test_handles_missing_source_gracefully(): void
    {
        Storage::fake('public');

        $missing_path = 'foods/' . date('Y/m') . '/not_exists.jpg';

        $food = Food::factory()->create([
          'mf_image_url' => $missing_path,
          'mf_image_disk' => 'public',
        ]);

        $manager = ImageManager::gd();
        $job = new ProcessFoodImage($food, $missing_path, 'public', $manager);

        $job->handle();

        $base_folder = rtrim(pathinfo($missing_path, PATHINFO_DIRNAME), '/') . '/' . ($food->mf_id ?? 'unknown') . '/';
        $files = Storage::disk('public')->allFiles($base_folder);

        $this->assertEmpty($files, 'Expected no files generated for missing source');
        $this->assertNull($food->fresh()->mf_image_variants, 'mf_image_variants should be null/empty when nothing produced');
    }

    public function test_invalid_image_does_not_create_variants(): void
    {
        Storage::fake('public');

        $path = 'foods/' . date('Y/m') . '/bad.txt';
        Storage::disk('public')->put($path, 'this is not an image');

        $food = Food::factory()->create([
          'mf_image_url' => $path,
          'mf_image_disk' => 'public',
        ]);

        $manager = ImageManager::gd();
        $job = new ProcessFoodImage($food, $path, 'public', $manager);

        $job->handle();

        $this->assertTrue(Storage::disk('public')->exists($path), 'Original non-image file was unexpectedly deleted');

        $base_folder = rtrim(pathinfo($path, PATHINFO_DIRNAME), '/') . '/' . ($food->mf_id ?? 'unknown') . '/';
        $files = Storage::disk('public')->allFiles($base_folder);
        $this->assertEmpty($files, 'Expected no files generated for invalid image');

        $this->assertNull($food->fresh()->mf_image_variants, 'mf_image_variants should be null/empty for invalid image');
    }
}
