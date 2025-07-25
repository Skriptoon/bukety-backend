<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\StorageConditionsTemplates;

use Illuminate\Foundation\Http\FormRequest;

class StoreStorageConditionsTemplatesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'value' => [
                'required',
                'string',
            ],
        ];
    }
}