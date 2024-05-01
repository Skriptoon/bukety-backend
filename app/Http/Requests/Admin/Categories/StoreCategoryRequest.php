<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'unique:categories,name',
            ],
            'description' => [
                'required_if:seo_description,null',
                'nullable',
                'string',
            ],
            'seo_description' => [
                'required_if:description,null',
                'nullable',
                'string',
            ],
            'image' => [
                'image',
                'nullable',
            ],
            'sort' => [
                'required',
                'integer',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
            'show_in_main' => [
                'required',
                'boolean',
            ],
        ];
    }
}