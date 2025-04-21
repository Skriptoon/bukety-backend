<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
                'required',
                'array',
            ],
            'image.file' => [
                'nullable',
                'dimensions:min_width=1200,min_height=1200',
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
                'nullable',
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
            'gallery.*.file' => [
                'nullable',
                'image',
                'dimensions:min_width=1200,min_height=1200',
            ],
            'uploaded_gallery_images' => [
                'required',
                'array',
            ],
            'uploaded_gallery_images.*' => [
                'string',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
