<?php

declare(strict_types=1);

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\Filter;

class Ids extends Filter
{
    /**
     */
    public function apply(Builder $query): Builder
    {
        return $query->whereIn('id', $this->values);
    }
}