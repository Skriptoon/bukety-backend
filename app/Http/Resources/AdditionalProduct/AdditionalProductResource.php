<?php
declare(strict_types=1);

namespace App\Http\Resources\AdditionalProduct;

use App\Models\AdditionalProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AdditionalProduct */
class AdditionalProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type->value,
            'price' => $this->price,
            'image' => $this->image_url,
        ];
    }
}
