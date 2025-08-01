<?php

declare(strict_types=1);

namespace App\DTO\Category;

use App\DTO\ImageDTO;
use Spatie\LaravelData\Data;

class CategoryDTO extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $seo_description,
        public ?int $parent_id,
        public ?ImageDTO $image,
        public bool $is_active,
        public bool $show_in_main,
        public bool $is_hidden,
    ) {
    }
}
