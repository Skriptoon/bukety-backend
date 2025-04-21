<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\Order\OrderDTO;
use App\Exceptions\PromoCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\ApplyPromoCodeRequest;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\PromoCode\PromoCodeResource;
use App\UseCases\Order\StoreOrderCase;
use App\UseCases\PromoCode\ApplyPromoCodeCase;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, StoreOrderCase $case): OrderResource
    {
        $dto = OrderDTO::from($request);

        return new OrderResource($case->handle($dto));
    }

    public function applyPromoCode(
        ApplyPromoCodeRequest $request,
        ApplyPromoCodeCase $case
    ): PromoCodeResource|JsonResponse {
        try {
            $promoCode = $case->handle($request->promo_code, $request->phone, (int)$request->product_id);

            return new PromoCodeResource($promoCode);
        } catch (PromoCodeException $exception) {
            return response()->json([
                'errors' => [
                    'promo_code' => [$exception->getMessage()],
                ]
            ], 422);
        }
    }
}
