<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\AdditionalProducts;

use App\Enums\AdditionalProductTypeEnum;
use App\Rules\ImageRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdditionalProductRequest extends FormRequest
{

    /**
     * @return array<string, ValidationRule|list<mixed>|string>
     */
    public function rules(): array
    {
        return  [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => [
                'required',
                Rule::enum(AdditionalProductTypeEnum::class),
            ],
            'image' => [
                'required',
                new ImageRule(),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}