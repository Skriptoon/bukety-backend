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
            ],
            'categories' => [
                'array',
                'required',
                'min:1',
            ],
            'categories.*' => [
                'integer',
            ],
            'description' => [
                'required',
                'string',
            ],
            'preview_description' => [
                'required',
                'string',
            ],
            'seo_description' => [
                'nullable',
                'string',
            ],
            'vk_url' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'integer',
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
            'gallery.*' => [
                function ($attribute, $value, $fail) {
                    $isImage = Validator::make(['value' => $value], ['value' => 'image'])->passes();
                    $isString = Validator::make(['value' => $value], ['value' => 'string'])->passes();

                    if (!$isImage && !$isString) {
                        $fail($attribute . ' должен быть изображением');
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