<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\AdditionalProducts;

use App\Rules\ImageRule;

class UpdateAdditionalProductRequest extends StoreAdditionalProductRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'image' => [
                'nullable',
                new ImageRule(),
            ]
        ]);
    }
}