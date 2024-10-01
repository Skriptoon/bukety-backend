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

        $category = CategoryModel::firstOrFail($value);
        $categories = $this->getChildrenCategoriesIds($category);
        $categories[] = $category->id;

        return $query->whereRelation('categories', function (Builder $query) use ($categories): void {
            $query->whereIn('category_id', $categories);
        });
    }

    private function getChildrenCategoriesIds(CategoryModel $category): array
    {
        $ids = [];
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            $ids = [...$ids, ...$this->getChildrenCategoriesIds($child)];
        }

        return $ids;
    }
}
