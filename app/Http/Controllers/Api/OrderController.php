<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\Order\OrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\BaseBooleanResource;
use App\UseCases\Order\StoreOrderCase;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, StoreOrderCase $case): BaseBooleanResource
    {
        $dto = OrderDTO::from($request);
        $case->handle($dto);

        return new BaseBooleanResource(true);
    }
}