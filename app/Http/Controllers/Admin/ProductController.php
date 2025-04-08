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
use App\Models\ProductIngredient;
use App\UseCases\Product\GenerateImageWithDescriptionCase;
use App\UseCases\Product\StoreProductCase;
use App\UseCases\Product\UpdateProductCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $query = Product::filter($request->toArray())
            ->with('categories')
            ->orderBy('id');

        if (!$request->get('with_disabled')) {
            $query->active();
        }

        $products = $query->paginate($perPage, page: $page);

        $categories = Category::orderBy('sort')
            ->get(['id', 'name'])
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]);

        return Inertia::render('Product/Index', [
            'products' => $products,
            'categories' => $categories,
            'vkProductFeed' => Storage::disk('public')->url('feeds/vk.yml'),
        ]);
    }

    public function edit(int $product): Response
    {
        $productModel = Product::with('categories', 'ingredients')->find($product);
        $categories = Category::orderBy('sort')
            ->get(['id', 'name', 'parent_id'])
            ->map(static function (Category $category) {
                $names = [$category->name];
                $currentCategory = $category;
                while ($currentCategory->parent) {
                    $names[] = $currentCategory->parent->name;
                    $currentCategory = $currentCategory->parent;
                }

                return [
                    'id' => $category->id,
                    'name' => implode(' → ', array_reverse($names)),
                ];
            });

        $previousUrl = null;
        if (str_contains(url()->previous(), route('products.index'))) {
            $previousUrl = url()->previous();
        }

        if (url()->previous() === url()->current()) {
            $previousUrl = session()->previousUrl();
        }

        return Inertia::render('Product/Edit', [
            'product' => $productModel,
            'categories' => $categories,
            'whomOptions' => WhomEnum::getOptions(),
            'occasionOptions' => OccasionEnum::getOptions(),
            'previousUrl' => $previousUrl,
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

        if ($request->redirect_url) {
            return redirect($request->redirect_url);
        }

        return redirect()->route('products.index');
    }

    public function create(): Response
    {
        $categories = Category::orderBy('sort')
            ->get(['id', 'name', 'parent_id'])
            ->map(static function (Category $category) {
                $names = [$category->name];
                $currentCategory = $category;
                while ($currentCategory->parent) {
                    $names[] = $currentCategory->parent->name;
                    $currentCategory = $currentCategory->parent;
                }

                return [
                    'id' => $category->id,
                    'name' => implode(' → ', array_reverse($names)),
                ];
            });

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

    public function getIngredients(Request $request): Collection
    {
        return ProductIngredient::where('name', 'ilike', '%' . $request->get('query') . '%')
            ->get();
    }

    public function getImageWithDescription(Product $product, GenerateImageWithDescriptionCase $case): StreamedResponse
    {
        $path = $case->handle($product);

        return Storage::download($path);
    }
}
