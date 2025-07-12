<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Order;

use App\Enums\CommunicationsMethodsEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|list<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^\+7 \([0-9]{3}\) [0-9]{3} [0-9]{2}-[0-9]{2}$/',
            ],
            'communication_method' => [
                'required',
                Rule::enum(CommunicationsMethodsEnum::class),
                'string',
            ],
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id'),
            ],
            'promo_code' => [
                'nullable',
                'string',
            ],
            'date' => [
                'required',
                'date',
                'after:today',
            ],
            'topper_id' => [
                'nullable',
                RUle::exists('additional_products', 'id')->where('is_active', true),
                'integer',
            ],
            'cart_id' => [
                'nullable',
                Rule::exists('additional_products', 'id')->where('is_active', true),
                'integer',
            ],
            'card_text' => [
                'nullable',
                'string',
                'exclude_without:card_id',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'communication_method' => 'Способ связи',
            'date' => 'Дата',
        ];
    }
}
