<?php

declare(strict_types=1);

namespace App\Filters\Product;

use App\Models\Category as CategoryModel;
use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\Filter;

class Category extends Filter
{
    public function apply(Builder $query): Builder
    {
        $value = $this->values[0] ?? null;

        $categories = [];
        $currentCategory = CategoryModel::findOrFail($value);
        while ($currentCategory) {
            $categories[] = $currentCategory->id;
            $currentCategory = $currentCategory->parent;
        }

        return $query->whereRelation('categories', 'id', $categories);
    }
}
