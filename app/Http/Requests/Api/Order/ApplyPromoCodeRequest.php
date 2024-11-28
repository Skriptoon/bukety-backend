<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $promo_code
 * @property-read string $phone
 * @property-read int $product_id
 */
class ApplyPromoCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'promo_code' => [
                'required',
                'string',
            ],
            'phone' => [
                'required',
                'string',
            ],
            'product_id' => [
                'required',
                'exists:products,id'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => 'Телефон',
            'promo_code' => 'Промокод',
        ];
    }
}
