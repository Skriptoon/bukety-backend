<?php

declare(strict_types=1);

namespace App\UseCases\Image;

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
    public function handle(string $imagePath, string $outputPath): string
    {
        if (! Storage::disk('public')->exists($outputPath)) {
            Storage::disk('public')->makeDirectory($outputPath);
        }

        $img = Image::fromFile($imagePath);

        $filename = $outputPath.'/'.uniqid('', true).'.webp';
        $img->save(Storage::disk('public')->path($filename));

        return $filename;
    }
}
