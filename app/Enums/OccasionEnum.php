<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enums\OptionsTrait;

enum OccasionEnum: string
{
    use OptionsTrait;

    case Birthday = 'birthday';
    case March8 = 'march8';
    case February23 = 'february23';
    case Anniversary = 'anniversary';
    case Graduation = 'graduation';
    case LastBell = 'last-bell';
    case NewYear = 'new-year';
    case MotherDay = 'mother-day';
    case February14 = 'february14';

    public function label(): string
    {
        return match ($this) {
            self::Birthday => 'День рождения',
            self::March8 => '8 марта',
            self::February23 => '23 февраля',
            self::Anniversary => 'Юбилей',
            self::Graduation => 'Выпускной',
            self::LastBell => 'Последний звонок',
            self::NewYear => 'Новый год',
            self::MotherDay => 'День матери',
            self::February14 => '14 февраля',
        };
    }
}
