<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\Models\Product;
use App\Models\ProductIngredient;

class UpdateProductIngredientsCase
{
    /**
     * @param Product $product
     * @param array<string>|null $ingredients
     * @return void
     */
    public function handle(Product $product, ?array $ingredients): void
    {
        $ingredientsIds = [];
        if ($ingredients !== null) {
            $ingredientsIds = ProductIngredient::whereIn('name', $ingredients)
                ->pluck('id', 'name');

            foreach ($ingredients as $ingredient) {
                if (!isset($ingredientsIds[$ingredient])) {
                    $ingredientModel = ProductIngredient::create([
                        'name' => mb_strtolower($ingredient),
                    ]);

                    $ingredientsIds[] = $ingredientModel->id;
                }
            }
        }

        $product->ingredients()->sync($ingredientsIds);
    }
}
