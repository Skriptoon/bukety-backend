<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\Category\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Http\Resources\BaseBooleanResource;
use App\Models\Category;
use App\UseCases\Category\StoreCategoryCase;
use App\UseCases\Category\UpdateCategoryCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::withoutGlobalScope('visible')
            ->whereNull('parent_id')
            ->orderBy('sort')
            ->get();

        return Inertia::render('Categories/Index', ['categories' => $categories]);
    }

    public function edit(Category $category): Response
    {
        $categories = Category::with('parent')
            ->orderBy('sort')
            ->where('id', '!=', $category->id)
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

        return Inertia::render('Categories/Edit', ['category' => $category, 'categories' => $categories]);
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category,
        UpdateCategoryCase $case
    ): RedirectResponse {
        $dto = CategoryDTO::from($request);

        $case->handle($category, $dto);

        return redirect(route('categories.index'));
    }

    public function create(): Response
    {
        $categories = Category::with('parent')
            ->orderBy('sort')
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

        return Inertia::render('Categories/Create', ['categories' => $categories]);
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function store(StoreCategoryRequest $request, StoreCategoryCase $case): RedirectResponse
    {
        $dto = CategoryDTO::from($request);

        $case->handle($dto);

        return redirect(route('categories.index'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect(route('categories.index'));
    }

    public function updateSort(Request $request): BaseBooleanResource
    {
        $ids = $request->get('category_ids', []);
        foreach ($ids as $key => $id) {
            Category::where('id', $id)
                ->update(['sort' => $key]);
        }

        return new BaseBooleanResource(true);
    }
}
