<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\Models\Product;
use App\Models\ProductIngredient;

class UpdateProductIngredientsCase
{
    public function handle(Product $product, ?array $ingredients): void
    {
        if ($ingredients === null) {
            return;
        }

        $ingredientsIds = ProductIngredient::whereIn('name', $ingredients)
            ->pluck('id', 'name');

        foreach ($ingredients ?? [] as $ingredient) {
            if (!isset($ingredientsIds[$ingredient])) {
                $ingredientModel = ProductIngredient::create([
                    'name' => mb_strtolower($ingredient),
                ]);

                $ingredientsIds[] = $ingredientModel->id;
            }
        }

        $product->ingredients()->sync($ingredientsIds);
    }
}
