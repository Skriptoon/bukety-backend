<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $page = $request->get('page', 1);
        $products = Product::active()
            ->filter($request->toArray())
            ->with(['categories', 'ingredients', 'mainCategory'])
            ->paginate(20, page: $page);

        return ProductResource::collection($products);
    }

    public function show(string $product): ProductResource
    {
        $productModel = Product::active()
            ->with(['categories', 'ingredients', 'mainCategory'])
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
            ->with(['categories', 'ingredients', 'mainCategory'])
            ->whereNot('id', $product->id)
            ->orderBy(new Expression('RANDOM()'))
            ->limit(10)
            ->get();

        return ProductResource::collection($recommended);
    }

    public function stocks(): AnonymousResourceCollection
    {
        $products = Product::active()
            ->with('categories', 'ingredients')
            ->whereNotNull('old_price')
            ->limit(10)
            ->inRandomOrder()
            ->get();

        return ProductResource::collection($products);
    }
}
