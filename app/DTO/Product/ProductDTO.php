<?php

declare(strict_types=1);

namespace App\DTO\Product;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ProductDTO extends Data
{
    public function __construct(
        public string $name,
        public array $categories,
        public string $description,
        public string $preview_description,
        public ?string $seo_description,
        public string $vk_url,
        public int $price,
        public ?UploadedFile $image,
        public array $gallery,
        public bool $is_active,
    ) {
    }
}