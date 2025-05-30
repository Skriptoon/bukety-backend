<?php

declare(strict_types=1);

namespace App\Filters\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\Filter;

class Ids extends Filter
{
    /**
     * @param Builder<Product> $query
     * @return Builder<Product>
     */
    public function apply(Builder $query): Builder
    {
        return $query->whereIn('id', $this->values);
    }
}