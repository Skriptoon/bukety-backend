<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdditionalProduct\AdditionalProductResource;
use App\Models\AdditionalProduct;
use Illuminate\Http\JsonResponse;

class AdditionalProductController extends Controller
{
    /**
     * Возвращает список всех активных дополнительных товаров.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $activeProducts = AdditionalProduct::where('is_active', true)
            ->withTrashed() // опционально — если нужно включить мягко удалённые
            ->get();

        return response()->json([
            'data' => AdditionalProductResource::collection($activeProducts),
        ], 200);
    }
}
