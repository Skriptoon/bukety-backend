<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Unique;

class UpdateCategoryRequest extends StoreCategoryRequest
{
    /**
     * @return array<string, ValidationRule|array<ValidationRule|string|Unique>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $category = $this->route('category');

        return array_merge($rules, [
            'name' => [
                'required',
                'string',
                new Unique('categories', 'name')->ignore($category),
            ],
        ]);
    }
}
