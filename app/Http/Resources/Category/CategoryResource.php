<?php

declare(strict_types=1);

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Category $resource
 */
class CategoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'description' => $this->resource->description,
            'seo_description' => $this->resource->seo_description,
            'children' => CategoryListResource::collection($this->resource->children),
            'parent' => $this->resource->parent ? new CategoryListResource($this->resource->parent) : null,
            'is_hidden' => $this->resource->is_hidden,
        ];
    }
}
