<?php

declare(strict_types=1);

namespace App\UseCases\Order;

use App\DTO\Order\OrderDTO;
use App\Enums\OrderStatusEnum;
use App\Exceptions\PromoCodeException;
use App\Models\Order;
use App\Models\Product\Product;
use App\UseCases\PromoCode\ApplyPromoCodeCase;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiMessagesCantFwdException;
use VK\Exceptions\Api\VKApiMessagesChatBotFeatureException;
use VK\Exceptions\Api\VKApiMessagesChatDisabledException;
use VK\Exceptions\Api\VKApiMessagesChatNotAdminException;
use VK\Exceptions\Api\VKApiMessagesChatUnsupportedException;
use VK\Exceptions\Api\VKApiMessagesChatUserLeftException;
use VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException;
use VK\Exceptions\Api\VKApiMessagesContactNotFoundException;
use VK\Exceptions\Api\VKApiMessagesDenySendException;
use VK\Exceptions\Api\VKApiMessagesIntentCantUseException;
use VK\Exceptions\Api\VKApiMessagesIntentLimitOverflowException;
use VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException;
use VK\Exceptions\Api\VKApiMessagesMessageCannotBeForwardedException;
use VK\Exceptions\Api\VKApiMessagesPeerBlockedReasonByTimeException;
use VK\Exceptions\Api\VKApiMessagesPrivacyException;
use VK\Exceptions\Api\VKApiMessagesTooLongForwardsException;
use VK\Exceptions\Api\VKApiMessagesTooLongMessageException;
use VK\Exceptions\Api\VKApiMessagesTooManyPostsException;
use VK\Exceptions\Api\VKApiMessagesUserBlockedException;
use VK\Exceptions\Api\VKApiMessagesUserNotDonException;
use VK\Exceptions\Api\VKApiNotFoundException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

readonly class StoreOrderCase
{
    public function __construct(
        private ApplyPromoCodeCase $applyPromoCodeCase,
        private VkApiClient $vkApiClient
    ) {
    }

    /**
     * @throws VKApiMessagesChatNotAdminException
     * @throws VKApiMessagesPrivacyException
     * @throws VKApiMessagesChatBotFeatureException
     * @throws VKClientException
     * @throws VKApiMessagesCantFwdException
     * @throws VKApiMessagesKeyboardInvalidException
     * @throws VKApiNotFoundException
     * @throws VKApiMessagesDenySendException
     * @throws VKApiMessagesIntentLimitOverflowException
     * @throws VKApiMessagesTooLongMessageException
     * @throws VKApiMessagesUserNotDonException
     * @throws VKApiMessagesChatUserLeftException
     * @throws VKApiMessagesMessageCannotBeForwardedException
     * @throws VKApiMessagesChatUserNoAccessException
     * @throws VKApiMessagesChatUnsupportedException
     * @throws VKApiMessagesTooManyPostsException
     * @throws VKApiMessagesIntentCantUseException
     * @throws VKApiMessagesUserBlockedException
     * @throws VKApiMessagesPeerBlockedReasonByTimeException
     * @throws VKApiException
     * @throws VKApiMessagesChatDisabledException
     * @throws VKApiMessagesTooLongForwardsException
     * @throws VKApiMessagesContactNotFoundException
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

        $this->notify($order);

        return $order;
    }

    /** @infection-ignore-all */
    private function notify(Order $order): void
    {
        $message = 'Новый заказ
Букет: ' . route('products.edit', $order->product_id) . "
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
