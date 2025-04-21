<?php

declare(strict_types=1);

namespace App\DTO\Product;

use App\DTO\ImageDTO;
use Spatie\LaravelData\Data;

class ProductDTO extends Data
{
    /**
     * @param string $name
     * @param int $main_category
     * @param int[] $categories
     * @param string $description
     * @param string|null $vk_description
     * @param string|null $seo_description
     * @param float $price
     * @param float|null $old_price
     * @param ImageDTO|null $image
     * @param array<ImageDTO> $gallery
     * @param string[] $whom
     * @param string[] $occasion
     * @param string[]|null $ingredients
     * @param array<string>|null $uploaded_gallery_images
     * @param bool $is_active
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
        public ?ImageDTO $image,
        public ?array $gallery,
        public array $whom,
        public array $occasion,
        public ?array $ingredients,
        public ?array $uploaded_gallery_images,
        public bool $is_active,
    ) {
    }
}
