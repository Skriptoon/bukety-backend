<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'unique:products,name',
                'max: 60',
            ],
            'main_category' => [
                'integer',
                'exists:categories,id',
            ],
            'categories' => [
                'array',
                'required',
                'min:1',
            ],
            'categories.*' => [
                'integer',
                'exists:categories,id',
            ],
            'description' => [
                'required',
                'string',
            ],
            'vk_description' => [
                'nullable',
                'string',
                'max:255',
            ],
            'preview_description' => [
                'required',
                'string',
                'max:255',
            ],
            'seo_description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'integer',
            ],
            'old_price' => [
                'nullable',
                'integer',
                'gt:price',
            ],
            'image' => [
                'image',
                'required',
            ],
            'gallery' => [
                'required',
                'array',
                'min:1',
            ],
            'whom' => [
                'required',
                'array',
            ],
            'whom.*' => [
                'string',
            ],
            'occasion' => [
                'required',
                'array',
            ],
            'occasion.*' => [
                'string',
            ],
            'ingredients' => [
                'nullable',
                'array',
            ],
            'ingredients.*' => [
                'string',
            ],
            'gallery.*' => [
                function ($attribute, $value, $fail) {
                    $isImage = Validator::make(['value' => $value], ['value' => 'image'])->passes();
                    $isString = Validator::make(['value' => $value], ['value' => 'string'])->passes();

                    if (! $isImage && ! $isString) {
                        $fail($attribute.' должен быть изображением');
                    }
                },
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
