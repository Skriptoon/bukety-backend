<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductIngredient;
use App\UseCases\Product\UpdateProductIngredientsCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_update_ingredients()
    {
        $product = Product::factory()->create();
        $ingredient = ProductIngredient::factory()->create();

        /** @var UpdateProductIngredientsCase $case */
        $case = app(UpdateProductIngredientsCase::class);

        $case->handle($product, ['Состав', 'Ингредиенты', $ingredient->name]);
        $ingredients = $product->ingredients()->pluck('name');


        $this->assertTrue($ingredients->contains('Состав'));
        $this->assertTrue($ingredients->contains('Ингредиенты'));
        $this->assertTrue($ingredients->contains($ingredient->name));
    }
}
