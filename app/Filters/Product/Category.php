<?php

declare(strict_types=1);

namespace App\Filters\Product;

use App\Models\Category as CategoryModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\Filter;

class Category extends Filter
{
    /**
     * @param Builder<Product> $query
     * @return Builder<Product>
     */
    public function apply(Builder $query): Builder
    {
        $value = $this->values[0] ?? null;

        $category = CategoryModel::where(['id' => $value])
            ->firstOrFail();

        $categories = $this->getChildrenCategoriesIds($category);
        $categories[] = $category->id;

        return $query->whereRelation('categories', function (Builder $query) use ($categories): void {
            $query->whereIn('category_id', $categories);
        });
    }

    /**
     * @param CategoryModel $category
     * @return array<int>
     */
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
