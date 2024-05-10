<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Product $resource
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'preview_description' => $this->resource->preview_description,
            'description' => $this->resource->description,
            'seo_description' => $this->resource->seo_description,
            'price' => $this->resource->price,
            'image' => $this->resource->image_url,
            'url' => $this->resource->vk_url,
        ];
    }
}