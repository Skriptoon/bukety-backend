<?php

declare(strict_types=1);

namespace App\UseCases\PromoCode;

use App\Exceptions\PromoCodeException;
use App\Models\Product;
use App\Models\PromoCode;

class ApplyPromoCodeCase
{
    /**
     * @throws PromoCodeException
     */
    public function handle(string $promoCode, string $phone, int $productId): PromoCode
    {
        $promoCodeModel = PromoCode::wherePromoCode(strtoupper($promoCode))
            ->where('is_active', true)
            ->first();

        if ($promoCodeModel === null) {
            throw new PromoCodeException('Промокод не найден');
        }

        $expiredAt = $promoCodeModel->expired_at?->setHour(23) ?? now()->setHour(23);
        if ($expiredAt < now()) {
            throw new PromoCodeException('Действие промокода закончилось');
        }

        $product = Product::findOrFail($productId);
        if ($product->old_price) {
            throw new PromoCodeException('Промокод нельзя применить на товар со скидкой');
        }

        if ($promoCodeModel->is_disposable) {
            $promoCodeUsed = $promoCodeModel->orders()
                ->where('phone', $phone)
                ->exists();

            if ($promoCodeUsed) {
                throw new PromoCodeException('Промокод уже использован');
            }
        }

        return $promoCodeModel;
    }
}
