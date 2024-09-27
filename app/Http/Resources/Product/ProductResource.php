<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Enums\OccasionEnum;
use App\Enums\WhomEnum;
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

            $whom = array_map(static fn (string $item): string => WhomEnum::from($item)->label(), $whom);
            $occasion = array_map(static fn (string $item): string => OccasionEnum::from($item)->label(), $occasion);

            $seoDescription = $this->resource->preview_description.".\n"
                .'Отличный подарок '.implode(', ', $whom)
                .' на '.implode(', ', $occasion).".\n"
                .'Цена: '.$this->resource->price.'₽';
        }

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'preview_description' => $this->resource->preview_description,
            'description' => $this->resource->description,
            'seo_description' => $seoDescription,
            'price' => $this->resource->price,
            'image' => $this->resource->image_url,
            'gallery' => $this->resource->gallery_urls,
            'url' => $this->resource->vk_url,
            'whom' => array_map(
                static fn (string $item): string => WhomEnum::from($item)->label(),
                $this->resource->whom
            ),
            'occasion' => array_map(
                static fn (string $item): string => OccasionEnum::from($item)->label(),
                $this->resource->occasion
            ),
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
