<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enums\OptionsTrait;

enum AdditionalProductTypeEnum: string
{
    use OptionsTrait;
    
    case Postcard = 'postcard';
    case Topper = 'topper';

    public function label(): string
    {
        return match ($this) {
            self::Postcard => 'Открытка',
            self::Topper => 'Топпер',
        };
    }
}
