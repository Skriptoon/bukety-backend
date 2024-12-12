<?php

declare(strict_types=1);

namespace App\UseCases\Order;

use App\DTO\Order\OrderDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\UseCases\PromoCode\ApplyPromoCodeCase;
use Throwable;
use VK\Client\VKApiClient;

readonly class StoreOrderCase
{
    public function __construct(
        private ApplyPromoCodeCase $applyPromoCodeCase,
        private VkApiClient $vkApiClient
    ) {
    }

    public function handle(OrderDTO $orderDto): void
    {
        try {
            $promoCode = $this->applyPromoCodeCase->handle(
                $orderDto->promo_code,
                $orderDto->phone,
                $orderDto->product_id
            );
        } catch (Throwable $exception) {
            $promoCode = null;
        }

        $product = Product::find($orderDto->product_id);
        $price = $product->price;
        if ($promoCode) {
            $price = round($price * (100 - $promoCode->discount) / 100);
        }

        Order::create([
            'name' => $orderDto->name,
            'phone' => $orderDto->phone,
            'communication_method' => $orderDto->communication_method,
            'status' => OrderStatusEnum::New,
            'product_id' => $orderDto->product_id,
            'promo_code_id' => $promoCode?->id,
            'price' => $price,
        ]);

        $message = 'Новый заказ
Букет: ' . route('products.edit', $orderDto->product_id) . "
Цена с учетом скидок: $price ₽
Телефон: {$orderDto->phone}
Способ связи: " . $orderDto->communication_method->label();

        $this->vkApiClient->messages()->send(config('api_keys.vk_api_key'), [
            'random_id' => 0,
            'peer_id' => 455222640,
            'message' => $message,
        ]);
    }
}
