<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Validation\Rules\Unique;

class UpdateCategoryRequest extends StoreCategoryRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $category = $this->route('category');

        return array_merge($rules, [
            'name' => [
                'required',
                'string',
                (new Unique('categories', 'name'))->ignore($category),
            ],
        ]);
    }
}