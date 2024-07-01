<?php

declare(strict_types=1);

namespace App\UseCases\Order;

use App\DTO\Order\OrderDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Order;

class StoreOrderCase
{
    public function handle(OrderDTO $orderDto): void
    {
        Order::create([
            'name' => $orderDto->name,
            'phone' => $orderDto->phone,
            'communication_method' => $orderDto->communication_method,
            'status' => OrderStatusEnum::New,
            'product_id' => $orderDto->product_id,
        ]);
    }
}