<?php

declare(strict_types=1);

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\Filter;

class Category extends Filter
{
    public function apply(Builder $query): Builder
    {
        $value = $this->values[0] ?? null;

        return $query->whereHas('categories', function (Builder $query) use ($value): void {
            $query->where('id', $value);
        });
    }
}