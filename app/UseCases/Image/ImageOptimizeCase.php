<?php

declare(strict_types=1);

namespace App\UseCases\Image;

use App\DTO\ImageDTO;
use Nette\Utils\Image;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Storage;

class ImageOptimizeCase
{
    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function handle(ImageDTO $imageData, string $outputPath): string
    {
        if (!Storage::disk('public')->exists($outputPath)) {
            Storage::disk('public')->makeDirectory($outputPath);
        }

        $img = Image::fromFile($imageData->file->path());

        if ($imageData->left !== null && $imageData->top !== null && $imageData->height !== null && $imageData->width !== null) {
            $img->crop($imageData->left, $imageData->top, $imageData->width, $imageData->height);
        }

        $filename = $outputPath . '/' . uniqid('', true) . '.webp';
        $img->save(Storage::disk('public')->path($filename));

        return $filename;
    }
}
