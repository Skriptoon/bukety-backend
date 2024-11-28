<?php

declare(strict_types=1);

use App\DTO\PromoCode\PromoCodeDTO;
use App\Exceptions\PromoCodeException;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use App\UseCases\PromoCode\ApplyPromoCodeCase;
use App\UseCases\PromoCode\StorePromoCodeCase;
use App\UseCases\PromoCode\UpdatePromoCodeCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PromoCodeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_store_promo_code(): void
    {
        $data = [
            'promo_code' => strtoupper($this->faker->word()),
            'discount' => $this->faker->numberBetween(1, 99),
            'expired_at' => $this->faker->date(DateTimeInterface::ATOM, now()->addDays(30)),
            'is_disposable' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
        ];

        $dto = PromoCodeDTO::from($data);

        /** @var StorePromoCodeCase $case */
        $case = app(StorePromoCodeCase::class);
        $case->handle($dto);

        $data['is_active'] = (int)$data['is_active'];
        $data['expired_at'] = Carbon::createFromFormat(DateTimeInterface::ATOM, $data['expired_at'])->toDateTimeString(
        );

        $this->assertDatabaseHas('promo_codes', $data);
    }

    public function test_update_promo_code()
    {
        $promoCode = PromoCode::factory()->create();
        $data = [
            'promo_code' => strtoupper($this->faker->word()),
            'discount' => $this->faker->numberBetween(1, 99),
            'expired_at' => $this->faker->date(DateTimeInterface::ATOM, now()->addDays(30)),
            'is_disposable' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
        ];

        $dto = PromoCodeDTO::from($data);

        /** @var UpdatePromoCodeCase $case */
        $case = app(UpdatePromoCodeCase::class);
        $case->handle($promoCode, $dto);

        $data['is_active'] = (int)$data['is_active'];
        $data['expired_at'] = Carbon::createFromFormat(DateTimeInterface::ATOM, $data['expired_at'])->toDateTimeString(
        );

        $this->assertDatabaseHas('promo_codes', $data);
    }

    /**
     * @throws PromoCodeException
     */
    public function test_apply_promo_code()
    {
        /** @var ApplyPromoCodeCase $case */
        $case = app(ApplyPromoCodeCase::class);

        $product = Product::factory()->create(['old_price' => null]);
        $promoCode = PromoCode::factory()->create(['expired_at' => null, 'is_active' => true]);
        $this->assertEquals(
            $case->handle($promoCode->promo_code, '', $product->id)->id,
            $promoCode->id
        );

        $promoCode = PromoCode::factory()->create(['expired_at' => now(), 'is_active' => true]);
        $this->assertEquals(
            $case->handle($promoCode->promo_code, '', $product->id)->id,
            $promoCode->id
        );

        $this->assertThrows(
            static fn () => $case->handle('test', 'test', $product->id),
            PromoCodeException::class,
        );

        $promoCode = PromoCode::factory()->create(['expired_at' => now()->subDay(), 'is_active' => true]);
        $this->assertThrows(
            static fn () => $case->handle($promoCode->promo_code, 'test', $product->id),
            PromoCodeException::class,
        );

        $promoCode = PromoCode::factory()->create(
            ['expired_at' => now(), 'is_active' => true, 'is_disposable' => true]
        );
        $order = Order::factory()->create(['promo_code_id' => $promoCode->id]);

        $this->assertThrows(
            static fn () => $case->handle($promoCode->promo_code, $order->phone, $product->id),
            PromoCodeException::class,
        );

        $product = Product::factory()->create(['old_price' => 123]);
        $this->assertThrows(
            static fn () => $case->handle($promoCode->promo_code, $order->phone, $product->id),
            PromoCodeException::class,
        );
    }
}
