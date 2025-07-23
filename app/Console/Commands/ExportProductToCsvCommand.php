<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Product\Product;
use Illuminate\Console\Command;

class ExportProductToCsvCommand extends Command
{
    protected $signature = 'export:product';

    public function handle(): void
    {
        $products = Product::active()->get();

        $csvData = $products->map(static fn(Product $product): array => [
            $product->id,
            $product->slug,
            $product->name,
            $product->price,
            $product->image_url
        ]);

        $file = fopen('/app/products.csv', 'w');
        $csvData->each(static fn(array $row) => fputcsv($file, $row));
    }
}