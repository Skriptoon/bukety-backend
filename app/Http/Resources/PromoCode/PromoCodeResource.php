<?php

declare(strict_types=1);

namespace App\Http\Resources\PromoCode;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read PromoCode $resource
 */
class PromoCodeResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'promo_code' => $this->resource->promo_code,
            'discount' => $this->resource->discount,
        ];
    }
}
