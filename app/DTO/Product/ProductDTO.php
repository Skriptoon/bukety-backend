<?php

declare(strict_types=1);

namespace App\DTO\Product;

use App\DTO\ImageDTO;
use App\Enums\UnitEnum;
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
     * @param int|null $weight
     * @param int|null $width
     * @param int|null $height
     * @param ImageDTO|null $image
     * @param array<ImageDTO> $gallery
     * @param string[] $whom
     * @param string[] $occasion
     * @param array<string> $ingredients
     * @param array<int> $ingredient_values
     * @param array<UnitEnum> $ingredient_units
     * @param array<string>|null $uploaded_gallery_images
     * @param bool $is_active
     * @param bool $for_flowwow
     * @param string|null $storage_conditions
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
        public ?int $weight,
        public ?int $width,
        public ?int $height,
        public ?ImageDTO $image,
        public ?array $gallery,
        public array $whom,
        public array $occasion,
        public array $ingredients,
        public array $ingredient_values,
        public array $ingredient_units,
        public ?array $uploaded_gallery_images,
        public bool $is_active,
        public bool $for_flowwow,
        public ?string $storage_conditions,
    ) {
    }
}
