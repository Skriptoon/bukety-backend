<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $promo_code
 * @property-read string $phone
 * @property-read int $product_id
 */
class ApplyPromoCodeRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<ValidationRule|string>|string>
     */
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
                'regex:/^\+7 \([0-9]{3}\) [0-9]{3} [0-9]{2}-[0-9]{2}$/',
            ],
            'product_id' => [
                'required',
                'exists:products,id'
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'phone' => 'Телефон',
            'promo_code' => 'Промокод',
        ];
    }
}
