<?php

namespace App\Enums;

enum CommunicationsMethodsEnum: string
{
    case Call = 'call';
    case Whatsapp = 'whatsapp';
    case Viber = 'viber';
    case Telegram = 'telegram';

    public function label(): string
    {
        return match ($this) {
            self::Call => 'Позвонить',
            self::Whatsapp => 'Whatsapp',
            self::Viber => 'Viber',
            self::Telegram => 'Telegram',
        };
    }
}
