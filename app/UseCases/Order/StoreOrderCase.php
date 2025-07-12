<?php

declare(strict_types=1);

namespace App\UseCases\Order;

use App\DTO\Order\OrderDTO;
use App\Enums\AdditionalProductTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Exceptions\PromoCodeException;
use App\Models\AdditionalProduct;
use App\Models\Order;
use App\Models\Product\Product;
use App\UseCases\PromoCode\ApplyPromoCodeCase;
use Exception;
use VK\Client\VKApiClient;

readonly class StoreOrderCase
{
    public function __construct(
        private ApplyPromoCodeCase $applyPromoCodeCase,
        private VkApiClient $vkApiClient
    ) {
    }

    /**
     * @param OrderDTO $orderDto
     * @return Order
     */
    public function handle(OrderDTO $orderDto): Order
    {
        $promoCode = null;
        if ($orderDto->promo_code) {
            try {
                $promoCode = $this->applyPromoCodeCase->handle(
                    $orderDto->promo_code,
                    $orderDto->phone,
                    $orderDto->product_id
                );
            } catch (PromoCodeException $exception) {
            }
        }

        $product = Product::findOrFail($orderDto->product_id);
        $price = $product->price;
        if ($promoCode) {
            $price = round($price * (100 - $promoCode->discount) / 100);
        }

        $order = Order::create([
            'name' => $orderDto->name,
            'phone' => $orderDto->phone,
            'communication_method' => $orderDto->communication_method,
            'status' => OrderStatusEnum::New,
            'product_id' => $orderDto->product_id,
            'promo_code_id' => $promoCode?->id,
            'price' => $price,
            'date' => $orderDto->date,
        ]);

        $this->addAdditionalProducts($order, $orderDto);

        $this->notify($order);

        return $order;
    }

    private function addAdditionalProducts(Order $order, OrderDTO $orderDto): void
    {
        if ($orderDto->topper_id) {
            $topper = AdditionalProduct::findOrFail($orderDto->topper_id);
            $order->additionalProducts()->attach($topper);
            $order->price += $topper->price;
        }

        if ($orderDto->card_id) {
            $card = AdditionalProduct::findOrFail($orderDto->card_id);
            $order->additionalProducts()->attach($card, ['value' => $orderDto->card_text]);
            $order->price += $card->price;
        }

        $order->save();
    }

    /**
     * @infection-ignore-all
     * @throws Exception
     */
    private function notify(Order $order): void
    {
        $topper = $order->additionalProducts()->where('type', AdditionalProductTypeEnum::Topper)->first();
        $card = $order->additionalProducts()
            ->where('type', AdditionalProductTypeEnum::Postcard)
            ->withPivot('value')
            ->first();

        $message = 'Новый заказ
Букет: ' . route('products.edit', $order->product_id) .
            ($topper ? "\nТоппер: " . route('additional-products.edit', $topper->id) : '') .
            ($card ? "\nОткрытка: " . route('additional-products.edit', $card->id) : '') .
            /** @phpstan-ignore-next-line property.notFound */
            ($card?->pivot?->value ? "\nТекст: {$card->pivot->value}" : '') . "
Дата: {$order->date?->format('d.m.Y')}
Цена с учетом скидок: {$order->price} ₽
Телефон: {$order->phone}
Способ связи: " . $order->communication_method->label();

        if (app()->isProduction()) {
            $this->vkApiClient->messages()->send(config('api_keys.vk_api_key'), [
                'random_id' => 0,
                'peer_id' => 455222640,
                'message' => $message,
            ]);

            $this->vkApiClient->messages()->send(config('api_keys.vk_api_key'), [
                'random_id' => 0,
                'peer_id' => 140578599,
                'message' => $message,
            ]);
        }
    }
}
