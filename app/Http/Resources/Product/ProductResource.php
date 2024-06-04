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
        $seoDescription = $this->resource->seo_description;
        if ($seoDescription === null) {
            $whom = array_slice($this->resource->whom, 0, 4);
            $occasion = array_slice($this->resource->occasion, 0, 4);

            $seoDescription = $this->resource->preview_description . ".\n"
                . 'Отличный подарок ' . implode(',', $whom)
                . ' на ' . implode(',', $occasion) . ".\n"
                . 'Цена' . $this->resource->price . '₽';
        }

        return [
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'preview_description' => $this->resource->preview_description,
            'description' => $this->resource->description,
            'seo_description' => $seoDescription,
            'price' => $this->resource->price,
            'image' => $this->resource->image_url,
            'url' => $this->resource->vk_url,
        ];
    }
}