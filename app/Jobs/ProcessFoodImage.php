<?php

namespace App\Jobs;

use App\Domain\Models\Food;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AvifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ProcessFoodImage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        protected Food $food,
        protected string $path,
        protected string $disk = 'public',
        protected ?ImageManager $manager = null
    ) {
        if (!$this->manager) {
            $this->manager = extension_loaded('imagick') ? ImageManager::imagick() : ImageManager::gd();
        }
    }

    public function handle(): void
    {
        $disk = $this->disk;
        $src_path = $this->path;

        try {
            $disk_instance = Storage::disk($disk);

            if (! $disk_instance->exists($src_path)) {
                return;
            }
            $content = $disk_instance->get($src_path);
        } catch (Exception $e) {
            return;
        }

        $sizes = [480, 300, 150, 50];
        $quality_jpeg = 85;
        $quality_webp = 80;

        $variants = [
          'original' => $src_path,
          'jpeg' => [],
          'webp' => [],
          'avif' => [],
        ];

        try {
            $original_img = $this->manager->read($content);
        } catch (Exception $e) {
            return; // invalid image
        }

        try {
            $original_img->orient();
        } catch (Exception $e) {
            // ignore
        }

        $base_folder = rtrim(pathinfo($src_path, PATHINFO_DIRNAME), '/') . '/' . ($this->food->mf_id ?? 'unknown') . '/';
        $random_slug = substr(md5(uniqid((string) $this->food->mf_id, true)), 0, 8);

        foreach ($sizes as $size) {
            // JPEG
            try {
                $img = $this->manager->read($content);

                /** @var \Intervention\Image\Image $img */
                $img->resize($size, $size);

                $encoded_jpg = $img->encode(new JpegEncoder(quality: $quality_jpeg));
                $filename_jpg = "w{$size}_{$random_slug}.jpg";
                $path_jpg = $base_folder . $filename_jpg;
                $disk_instance->put($path_jpg, $encoded_jpg->toString(), ['visibility' => 'public']);
                $variants['jpeg'][(string)$size] = $path_jpg;
            } catch (Exception $e) {
                Log::error('ProcessFoodImage: jpeg failed', ['size'=>$size,'err'=>$e->getMessage()]);
            }

            // WEBP
            try {
                $img_webp = $this->manager->read($content);

                /** @var \Intervention\Image\Image $img_webp */
                $img_webp->resize($size, $size);

                $encoded_webp = $img_webp->encode(new WebpEncoder(quality: $quality_webp));

                $filename_webp = "w{$size}_{$random_slug}.webp";
                $path_webp = $base_folder . $filename_webp;
                $disk_instance->put($path_webp, $encoded_webp->toString(), ['visibility' => 'public']);
                $variants['webp'][(string)$size] = $path_webp;
            } catch (Exception $e) {
                Log::error('ProcessFoodImage: webp failed', ['size'=>$size,'err'=>$e->getMessage()]);
            }

            // AVIF (best effort)
            try {
                $img_avif = $this->manager->read($content);

                /** @var \Intervention\Image\Image $img_avif */
                $img_avif->resize($size, $size);

                $encoded_avif = $img_avif->encode(new AvifEncoder(quality: 50));

                $filename_avif = "w{$size}_{$random_slug}.avif";
                $path_avif = $base_folder . $filename_avif;
                $disk_instance->put($path_avif, $encoded_avif->toString(), ['visibility' => 'public']);
                $variants['avif'][(string)$size] = $path_avif;

            } catch (Exception $e) {
              Log::error('ProcessFoodImage: avif failed', ['size'=>$size,'err'=>$e->getMessage()]);
            }
        }

        // thumbnail (square)
        try {
            $thumb_img = $this->manager->read($content);
            $thumb_img->contain(300, 300);

            $encoded_thumb = $thumb_img->encode(new JpegEncoder(quality: 75));
            $thumb_path = $base_folder . "thumb_{$random_slug}.jpg";
            $disk_instance->put($thumb_path, $encoded_thumb->toString(), ['visibility' => 'public']);
            $variants['thumbnail'] = $thumb_path;
        } catch (Exception $e) {
        }

        try {
            $existing = is_array($this->food->mf_image_variants ?? null) ? $this->food->mf_image_variants : [];
            $this->food->mf_image_variants = array_merge($existing, $variants);
            $this->food->save();
        } catch (Exception $e) {
          Log::error('ProcessFoodImage: thumbnail failed', ['size'=>$size,'err'=>$e->getMessage()]);
        }

        try {
            $disk_instance->delete($src_path);
        } catch (Exception $e) {
        }
    }
}
