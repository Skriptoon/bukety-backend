<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Unique;

/**
 *  @property-read string|null $redirect_url
 */
class UpdateProductRequest extends StoreProductRequest
{
    /**
     * @return array<string, ValidationRule|array<ValidationRule|string|Unique>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $product = $this->route('product');

        return array_merge($rules, [
            'name' => [
                'required',
                'string',
                new Unique('products', 'name')->ignore($product),
            ],
            'image' => [
                'nullable',
                'array',
            ],
            'image.file' => [
                'image',
                'nullable',
                'dimensions:min_width=1200,min_height=1200'
            ],
            'image.top' => [
                'nullable',
                'integer',
            ],
            'image.left' => [
                'nullable',
                'integer',
            ],
            'image.width' => [
                'nullable',
                'integer',
            ],
            'image.height' => [
                'nullable',
                'integer',
            ],
            'gallery' => [
                'array',
                'nullable',
            ],
            'redirect_url' => [
                'nullable',
                'url',
            ],
        ]);
    }
}
