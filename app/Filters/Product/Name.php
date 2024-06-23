<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\Filter;

class Name extends Filter
{
    public function apply(Builder $query): Builder
    {
        $value = $this->values[0] ?? null;

        return $query->where('name', 'ilike', "%$value%");
    }
}