<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\PromoCode\PromoCodeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromoCodes\StorePromoCodeRequest;
use App\Http\Requests\Admin\PromoCodes\UpdatePromoCodeRequest;
use App\Models\PromoCode;
use App\UseCases\PromoCode\StorePromoCodeCase;
use App\UseCases\PromoCode\UpdatePromoCodeCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PromoCodeController extends Controller
{
    public function index(): Response
    {
        $promoCodes = PromoCode::all();

        return Inertia::render('PromoCodes/Index', ['promoCodes' => $promoCodes]);
    }

    public function create(): Response
    {
        return Inertia::render('PromoCodes/Create');
    }

    public function edit(PromoCode $promoCode): Response
    {
        return Inertia::render('PromoCodes/Edit', ['promoCode' => $promoCode]);
    }

    public function store(StorePromoCodeRequest $request, StorePromoCodeCase $case): RedirectResponse
    {
        $dto = PromoCodeDTO::from($request);
        $case->handle($dto);

        return redirect()->route('promo-codes.index');
    }

    public function update(
        UpdatePromoCodeRequest $request,
        PromoCode $promoCode,
        UpdatePromoCodeCase $case
    ): RedirectResponse {
        $dto = PromoCodeDTO::from($request);
        $case->handle($promoCode, $dto);

        return redirect()->route('promo-codes.index');
    }

    public function destroy(PromoCode $promoCode): RedirectResponse
    {
        if ($promoCode->orders()->exists()) {
            $promoCode->delete();
        } else {
            $promoCode->forceDelete();
        }

        return redirect()->route('promo-codes.index');
    }
}
