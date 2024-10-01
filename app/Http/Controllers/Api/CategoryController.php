<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryListResource;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = Category::active()
            ->visible()
            ->filter($request->toArray())
            ->whereNull('parent_id')
            ->orderBy('sort')
            ->get();

        return CategoryListResource::collection($categories);
    }

    public function show(string $category): CategoryResource
    {
        $categoryModel = Category::active()->where('slug', $category)->firstOrFail();

        return new CategoryResource($categoryModel);
    }
}
