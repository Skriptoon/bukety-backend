<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enums\OptionsTrait;

enum WhomEnum: string
{
    use OptionsTrait;

    case Man = 'man';
    case Women = 'women';
    case Mother = 'mother';
    case Father = 'father';
    case Sister = 'sister';
    case Brother = 'brother';
    case Husband = 'husband';
    case Wife = 'wife';
    case Grandson = 'grandson';
    case Granddaughter = 'granddaughter';
    case Grandfather = 'grandfather';
    case Grandmother = 'grandmother';
    case Colleague = 'colleague';
    case Mentor = 'mentor';
    case Teacher = 'teacher';
    case Friend = 'friend';
    case Girlfriend = 'girlfriend';

    public function label(): string
    {
        return match ($this) {
            self::Man => 'Мужчине',
            self::Women => 'Женщине',
            self::Mother => 'Маме',
            self::Father => 'Папе',
            self::Sister => 'Сестре',
            self::Brother => 'Брату',
            self::Husband => 'Мужу',
            self::Wife => 'Жене',
            self::Grandson => 'Внуку',
            self::Granddaughter => 'Внучке',
            self::Colleague => 'Коллеге',
            self::Grandfather => 'Дедушке',
            self::Grandmother => 'Бубушке',
            self::Mentor => 'Воспиталю',
            self::Teacher => 'Учителю',
            self::Girlfriend => 'Подруге',
            self::Friend => 'Другу',
        };
    }
}
