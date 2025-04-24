<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\Enums\UnitEnum;
use App\Models\Product\Product;
use App\Models\Product\ProductIngredient;

class UpdateProductIngredientsCase
{
    /**
     * @param Product $product
     * @param array<string> $ingredients
     * @param array<int> $value
     * @param array<UnitEnum> $units
     * @return void
     */
    public function handle(Product $product, array $ingredients, array $value, array $units): void
    {
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

        $product->ingredients()->sync($ingredientsIds);

        $ingredientModels = $product->ingredients;
        foreach ($ingredientModels as $ingredientModel) {
            $index = array_search($ingredientModel->name, $ingredients);
            if ($ingredientModel->pivot) {
                $ingredientModel->pivot->unit = $units[$index];
                $ingredientModel->pivot->value = $value[$index];
                $ingredientModel->pivot->save();
            }
        }
    }
}
