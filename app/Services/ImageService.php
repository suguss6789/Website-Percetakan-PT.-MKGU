<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Menyimpan gambar upload: diperkecil ke lebar maks. 1600 px,
 * dikonversi ke WebP (jika GD mendukung), dan dibuatkan thumbnail 600 px.
 * Hanya memakai ekstensi GD bawaan PHP supaya jalan di hosting murah/gratis.
 */
class ImageService
{
    public const MAX_WIDTH = 1600;
    public const THUMB_WIDTH = 600;

    public function store(UploadedFile $file, string $dir = 'products'): string
    {
        $disk = Storage::disk('public');
        $source = $this->load($file->getRealPath());

        if (! $source) {
            // GD tidak bisa membaca → simpan apa adanya.
            return $file->store($dir, 'public');
        }

        $useWebp = function_exists('imagewebp');
        $ext = $useWebp ? 'webp' : 'jpg';
        $name = Str::random(32) . '.' . $ext;
        $path = trim($dir, '/') . '/' . $name;

        $disk->put($path, $this->encode($this->resize($source, self::MAX_WIDTH), $useWebp));
        $disk->put(thumb_path($path), $this->encode($this->resize($source, self::THUMB_WIDTH), $useWebp));

        imagedestroy($source);

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete([$path, thumb_path($path)]);
        }
    }

    private function load(string $realPath): \GdImage|false
    {
        $info = @getimagesize($realPath);
        if (! $info) {
            return false;
        }

        $image = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($realPath),
            IMAGETYPE_PNG => @imagecreatefrompng($realPath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($realPath) : false,
            default => false,
        };

        if ($image && $info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $orientation = @exif_read_data($realPath)['Orientation'] ?? 1;
            $image = match ($orientation) {
                3 => imagerotate($image, 180, 0),
                6 => imagerotate($image, -90, 0),
                8 => imagerotate($image, 90, 0),
                default => $image,
            };
        }

        return $image;
    }

    private function resize(\GdImage $src, int $maxWidth): \GdImage
    {
        $w = imagesx($src);
        $h = imagesy($src);
        $newW = min($w, $maxWidth);
        $newH = (int) round($h * ($newW / $w));

        $dst = imagecreatetruecolor($newW, $newH);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagefill($dst, 0, 0, imagecolorallocatealpha($dst, 255, 255, 255, 127));
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);

        return $dst;
    }

    private function encode(\GdImage $img, bool $webp): string
    {
        ob_start();
        if ($webp) {
            imagewebp($img, null, 82);
        } else {
            $flat = imagecreatetruecolor(imagesx($img), imagesy($img));
            imagefill($flat, 0, 0, imagecolorallocate($flat, 255, 255, 255));
            imagecopy($flat, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
            imagejpeg($flat, null, 84);
            imagedestroy($flat);
        }
        imagedestroy($img);

        return (string) ob_get_clean();
    }
}
