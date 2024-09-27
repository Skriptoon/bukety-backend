<?php

declare(strict_types=1);

namespace App\UseCases\Order;

use App\DTO\Order\OrderDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use VK\Client\VKApiClient;

readonly class StoreOrderCase
{
    public function __construct(private VkApiClient $vkApiClient)
    {
    }

    public function handle(OrderDTO $orderDto): void
    {
        Order::create([
            'name' => $orderDto->name,
            'phone' => $orderDto->phone,
            'communication_method' => $orderDto->communication_method,
            'status' => OrderStatusEnum::New,
            'product_id' => $orderDto->product_id,
        ]);

        $message = 'Новый заказ
Букет: '.route('products.edit', $orderDto->product_id)."
Телефон: {$orderDto->phone}
Способ связи: ".$orderDto->communication_method->label();

        $this->vkApiClient->messages()->send(config('api_keys.vk_api_key'), [
            'random_id' => 0,
            'peer_id' => 455222640,
            'message' => $message,
        ]);
    }
}
