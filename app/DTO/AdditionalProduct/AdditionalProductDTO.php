<?php

declare(strict_types=1);

namespace App\DTO\AdditionalProduct;

use App\DTO\ImageDTO;
use App\Enums\AdditionalProductTypeEnum;
use Spatie\LaravelData\Data;

class AdditionalProductDTO extends Data
{
    public string $name;
    public AdditionalProductTypeEnum $type;
    public ?ImageDTO $image;
    public float $price;
    public bool $is_active;
}