<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enums\OptionsTrait;

enum UnitEnum: string
{
    use OptionsTrait;

    case g = 'g';
    case pc = 'pc';

    public function label(): string
    {
        return match ($this) {
            self::g => 'гр',
            self::pc => 'шт',
        };
    }
}
