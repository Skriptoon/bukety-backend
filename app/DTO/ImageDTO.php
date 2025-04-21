<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ImageDTO extends Data
{
    public function __construct(
        public UploadedFile $file,
        public ?int $width,
        public ?int $height,
        public ?int $left,
        public ?int $top,
    ) {
    }
}