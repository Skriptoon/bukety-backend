<?php

declare(strict_types=1);

use App\DTO\Order\OrderDTO;
use App\Enums\CommunicationsMethodsEnum;
use App\Models\Product\Product;
use App\Models\PromoCode;
use App\UseCases\Order\StoreOrderCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @throws Exception
     */
    public function test_store_order()
    {
        $product = Product::factory()->create();
        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'communication_method' => $this->faker->randomElement(CommunicationsMethodsEnum::cases()),
            'product_id' => $product->id,
            'date' => (new Carbon($this->faker->date()))->format('Y-m-d 00:00:00'),
        ];

        $dto = OrderDTO::from($data);

        $case = app(StoreOrderCase::class);
        $case->handle($dto);

        $data['price'] = $product->price;

        $this->assertDatabaseHas('orders', $data);
    }

    /**
     * @throws Exception
     */
    public function test_store_order_with_promo_code()
    {
        $product = Product::factory()->create(['old_price' => null]);
        $promoCode = PromoCode::factory()->create(['is_active' => true, 'expired_at' => null,]);

        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'communication_method' => $this->faker->randomElement(CommunicationsMethodsEnum::cases()),
            'product_id' => $product->id,
            'date' => (new Carbon($this->faker->date()))->format('Y-m-d 00:00:00'),
            'promo_code' => $promoCode->promo_code,
        ];

        $dto = OrderDTO::from($data);

        $case = app(StoreOrderCase::class);
        $case->handle($dto);

        $data['price'] = round($product->price * (100 - $promoCode->discount) / 100);
        $data['promo_code_id'] = $promoCode->id;
        unset($data['promo_code']);

        $this->assertDatabaseHas('orders', $data);
    }
}
