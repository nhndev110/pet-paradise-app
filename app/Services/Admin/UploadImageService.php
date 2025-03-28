<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UploadImageService
{
    /**
     * Upload an image to storage.
     *
     * @param UploadedFile $image
     * @param string $folder
     * @param string|null $existingImage
     * @return string
     */
    public static function uploadImage(UploadedFile $image, string $folder): string
    {
        $path = $image->store($folder, 'public');
        return $path;
    }

    /**
     * Delete an image from storage.
     *
     * @param string $path
     * @return bool
     */
    public static function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Upload multiple images at once.
     *
     * @param array $images
     * @param string $folder
     * @return array
     */
    public static function uploadMultipleImages(array $images, string $folder): array
    {
        $paths = [];

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $paths[] = self::uploadImage($image, $folder);
            }
        }

        return $paths;
    }

    /**
     * Get the full URL for an image.
     *
     * @param string $path
     * @return string|null
     */
    public static function getImageUrl(string $path = ""): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}
