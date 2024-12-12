<?php

declare(strict_types=1);

namespace App\DTO\Order;

use App\Enums\CommunicationsMethodsEnum;
use Spatie\LaravelData\Data;

class OrderDTO extends Data
{
    public function __construct(
        public string $name,
        public string $phone,
        public int $product_id,
        public CommunicationsMethodsEnum $communication_method,
        public ?string $promo_code,
    ) {
    }
}
