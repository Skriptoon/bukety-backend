<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatusEnum: string
{
    case New = 'new';
    case Completed = 'completed';
}
