<?php

namespace App\Rules;

use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Validator;

class ImageRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = Validator::make(['image' => $value], [
            'image' => [
                'array',
            ],
            'image.file' => [
                'nullable',
                'image',
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
        ]);

        try {
            $validator->validate();

        } catch (Exception $e) {
            $fail($e->getMessage());
        }
    }
}
