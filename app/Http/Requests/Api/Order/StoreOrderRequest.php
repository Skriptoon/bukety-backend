<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Order;

use App\Enums\CommunicationsMethodsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string'
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
                Rule::exists('products','id'),
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'communication_method' => 'Сбособ связи',
        ];
    }
}