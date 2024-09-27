<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\Category\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Models\Category;
use App\UseCases\Category\StoreCategoryCase;
use App\UseCases\Category\UpdateCategoryCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::withoutGlobalScope('visible')
            ->orderBy('sort')
            ->get();

        return Inertia::render('Categories/Index', ['categories' => $categories]);
    }

    public function edit(Category $category): Response
    {
        $categories = Category::orderBy('sort')
            ->where('id', '!=', $category->id)
            ->get(['id', 'name'])
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]);

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
        $categories = Category::orderBy('sort')
            ->get(['id', 'name'])
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]);

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
}
