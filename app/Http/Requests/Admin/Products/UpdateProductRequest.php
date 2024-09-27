<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Products;

use Illuminate\Validation\Rules\Unique;

/**
 *  @property-read string|null $redirect_url
 */
class UpdateProductRequest extends StoreProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $product = $this->route('product');

        return array_merge($rules, [
            'name' => [
                'required',
                'string',
                (new Unique('products', 'name'))->ignore($product),
            ],
            'image' => [
                'image',
                'nullable',
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
