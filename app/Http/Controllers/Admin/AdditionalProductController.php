<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\AdditionalProduct\AdditionalProductDTO;
use App\Enums\AdditionalProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdditionalProducts\StoreAdditionalProductRequest;
use App\Http\Requests\Admin\AdditionalProducts\UpdateAdditionalProductRequest;
use App\Models\AdditionalProduct;
use App\UseCases\AdditionalProduct\StoreAdditionalProductCase;
use App\UseCases\AdditionalProduct\UpdateAdditionalProductCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Storage;

class AdditionalProductController extends Controller
{
    public function index(): Response
    {
        $additionalProducts = AdditionalProduct::all();

        return Inertia::render('AdditionalProduct/Index', compact('additionalProducts'));
    }

    public function create(): Response
    {
        $additionalProductTypes = AdditionalProductTypeEnum::getOptions();

        return Inertia::render('AdditionalProduct/Create', compact('additionalProductTypes'));
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function store(StoreAdditionalProductRequest $request, StoreAdditionalProductCase $case): RedirectResponse
    {
        $dto = AdditionalProductDTO::from($request);
        $case->handle($dto);

        return redirect()->route('additional-products.index');
    }

    public function edit(AdditionalProduct $additionalProduct): Response
    {
        $additionalProductTypes = AdditionalProductTypeEnum::getOptions();

        return Inertia::render(
            'AdditionalProduct/Edit',
            compact('additionalProductTypes', 'additionalProduct'),
        );
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function update(
        UpdateAdditionalProductRequest $request,
        AdditionalProduct $additionalProduct,
        UpdateAdditionalProductCase $case
    ): RedirectResponse {
        $dto = AdditionalProductDTO::from($request);
        $case->handle($additionalProduct, $dto);

        return redirect()->route('additional-products.index');
    }

    public function destroy(AdditionalProduct $additionalProduct): RedirectResponse
    {
        if ($additionalProduct->orders()->exists()) {
            Storage::disk('public')->delete($additionalProduct->image);
            $additionalProduct->delete();
        } else {
            $additionalProduct->forceDelete();
        }

        return redirect()->route('additional-products.index');
    }
}
