<?php

declare(strict_types=1);

namespace App\DTO\Category;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class CategoryDTO extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $seo_description,
        public ?UploadedFile $image,
        public int $sort,
        public bool $is_active,
        public bool $show_in_main,
    ) {
    }
}