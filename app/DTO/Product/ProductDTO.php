<?php

declare(strict_types=1);

namespace App\DTO\Product;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ProductDTO extends Data
{
    /**
     * @param  string  $name
     * @param  int  $main_category
     * @param  array  $categories
     * @param  string  $description
     * @param  string|null  $vk_description
     * @param  string|null  $seo_description
     * @param  float  $price
     * @param  float|null  $old_price
     * @param  UploadedFile|null  $image
     * @param  UploadedFile[]|string[]  $gallery
     * @param  array  $whom
     * @param  array  $occasion
     * @param  array|null  $ingredients
     * @param  bool  $is_active
     */
    public function __construct(
        public string $name,
        public int $main_category,
        public array $categories,
        public string $description,
        public ?string $vk_description,
        public ?string $seo_description,
        public float $price,
        public ?float $old_price,
        public ?UploadedFile $image,
        public array $gallery,
        public array $whom,
        public array $occasion,
        public ?array $ingredients,
        public bool $is_active,
    ) {
    }
}
