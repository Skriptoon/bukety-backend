<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $products = Product::active()
            ->filter($request->toArray())
            ->get();

        return ProductResource::collection($products);
    }

    public function show(string $product): ProductResource
    {
        $productModel = Product::active()
            ->where('slug', $product)
            ->firstOrFail();

        return new ProductResource($productModel);
    }

    public function recommended(Product $product): AnonymousResourceCollection
    {
        $categoryIds = $product->categories()->pluck('id');

        $recommended = Product::active()
            ->whereHas('categories', static function (Builder $query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->orderBy(new Expression('RANDOM()'))
            ->limit(10)
            ->get();

        return ProductResource::collection($recommended);
    }
}