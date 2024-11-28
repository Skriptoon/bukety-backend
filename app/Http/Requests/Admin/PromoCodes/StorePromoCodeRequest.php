<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\PromoCodes;

use Illuminate\Foundation\Http\FormRequest;

class StorePromoCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'promo_code' => [
                'required',
                'string',
                'unique:promo_codes,promo_code',
            ],
            'discount' => [
                'required',
                'integer',
                'min:1',
                'max:99',
            ],
            'expired_at' => [
                'nullable',
                'date',
            ],
            'is_disposable' => [
                'required',
                'boolean',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
