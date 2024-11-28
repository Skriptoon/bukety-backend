<?php

declare(strict_types=1);

namespace App\DTO\PromoCode;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class PromoCodeDTO extends Data
{
    public function __construct(
        public string $promo_code,
        public int $discount,
        public Carbon $expired_at,
        public bool $is_disposable,
        public bool $is_active,
    ) {
    }
}
