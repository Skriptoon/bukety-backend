<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdditionalProductResource;
use App\Models\AdditionalProduct;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdditionalProductController extends Controller
{
    /**
     * Получить все активные дополнительные товары.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $additionalProducts = AdditionalProduct::where('is_active', true)->get();

        return AdditionalProductResource::collection($additionalProducts);
    }
}
