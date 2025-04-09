<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Enums\OccasionEnum;
use App\Enums\WhomEnum;
use App\Http\Resources\Category\CategoryListResource;
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
        $seoDescription = $this->resource->seo_description;
        if ($seoDescription === null) {
            $seoDescription = 'Купить ' . $this->resource->name . ' цена ' . $this->resource->price . "₽.\n"
                . 'Заказать с доставкой по Екатеринбургу';
        }

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'main_category' => new CategoryListResource(
                $this->resource->mainCategory ?? $this->resource->categories->first()
            ),
            'description' => $this->resource->description,
            'seo_description' => $seoDescription,
            'price' => $this->resource->price,
            'old_price' => $this->resource->old_price,
            'image' => $this->resource->image_url,
            'gallery' => $this->resource->gallery_urls,
            'whom' => array_map(
                static fn (string $item): string => WhomEnum::from($item)->label(),
                $this->resource->whom
            ),
            'occasion' => array_map(
                static fn (string $item): string => OccasionEnum::from($item)->label(),
                $this->resource->occasion
            ),
            'ingredients' => $this->resource->ingredients->pluck('name'),
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
