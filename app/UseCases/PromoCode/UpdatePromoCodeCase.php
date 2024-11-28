<?php

declare(strict_types=1);

namespace App\UseCases\PromoCode;

use App\DTO\PromoCode\PromoCodeDTO;
use App\Models\PromoCode;

class UpdatePromoCodeCase
{
    public function handle(PromoCode $promoCode, PromoCodeDTO $data): void
    {
        $promoCode->update([
            'promo_code' => strtoupper($data->promo_code),
            'discount' => $data->discount,
            'expired_at' => $data->expired_at,
            'is_disposable' => $data->is_disposable,
            'is_active' => $data->is_active,
        ]);
    }
}
