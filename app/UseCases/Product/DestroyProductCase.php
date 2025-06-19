<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\Models\Product\Product;
use Storage;

class DestroyProductCase
{
    public function handle(Product $product): void
    {
        if ($product->orders()->exists()) {
            Storage::disk('public')->delete($product->image);
            Storage::disk('public')->delete($product->gallery);

            foreach ($product->ingredients as $ingredient) {
                if (!$ingredient->products()->exists()) {
                    $ingredient->delete();
                }
            }

            $product->forceDelete();
        } else {
            $product->delete();
        }
    }
}
