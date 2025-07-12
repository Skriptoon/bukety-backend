<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\AdditionalProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read AdditionalProduct $resource */
class AdditionalProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type->value,
            'price' => $this->resource->price,
            'image' => $this->resource->image_url,
            'is_active' => $this->resource->is_active,
        ];
    }
}
