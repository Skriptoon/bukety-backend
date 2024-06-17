<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\Product\ProductDTO;
use App\Enums\OccasionEnum;
use App\Enums\WhomEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\UseCases\Product\StoreProductCase;
use App\UseCases\Product\UpdateProductCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $products = Product::filter($request->toArray())
            ->with('categories')
            ->orderBy('id')
            ->paginate($perPage, page: $page);

        $categories = Category::orderBy('sort')
            ->get(['id', 'name'])
            ->map(fn($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]);

        return Inertia::render('Product/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function edit(int $product): Response
    {
        $product = Product::with('categories')->find($product);
        $categories = Category::orderBy('sort')
            ->get()
            ->map(fn($category) => [
                'value' => $category->id,
                'name' => $category->name,
            ]);

        return Inertia::render('Product/Edit', [
            'product' => $product,
            'categories' => $categories,
            'whomOptions' => WhomEnum::getOptions(),
            'occasionOptions' => OccasionEnum::getOptions(),
        ]);
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function update(Product $product, UpdateProductRequest $request, UpdateProductCase $case): RedirectResponse
    {
        $dto = ProductDTO::from($request);

        $case->handle($product, $dto);

        return redirect()->route('products.index');
    }

    public function create(): Response
    {
        $categories = Category::orderBy('sort')
            ->get()
            ->map(fn($category) => [
                'value' => (string)$category->id,
                'name' => $category->name,
            ]);

        return Inertia::render('Product/Create', [
            'categories' => $categories,
            'whomOptions' => WhomEnum::getOptions(),
            'occasionOptions' => OccasionEnum::getOptions(),
        ]);
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function store(StoreProductRequest $request, StoreProductCase $case): RedirectResponse
    {
        $dto = ProductDTO::from($request);

        $case->handle($dto);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}