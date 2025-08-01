<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<ValidationRule|string>|string>
     */
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
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],
            'image' => [
                'image',
                'nullable',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
            'is_hidden' => [
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
