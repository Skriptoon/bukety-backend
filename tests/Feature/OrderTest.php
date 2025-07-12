<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DTO\Order\OrderDTO;
use App\Enums\AdditionalProductTypeEnum;
use App\Enums\CommunicationsMethodsEnum;
use App\Models\AdditionalProduct;
use App\Models\Product\Product;
use App\Models\PromoCode;
use App\UseCases\Order\StoreOrderCase;
use Exception;
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
            'date' => new Carbon($this->faker->date()),
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
            'date' => new Carbon($this->faker->date()),
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

    /**
     * @throws Exception
     */
    public function test_store_order_with_topper()
    {
        $product = Product::factory()->create(['old_price' => null, 'is_active' => true,]);
        $topper = AdditionalProduct::factory()->create(
            ['type' => AdditionalProductTypeEnum::Topper, 'is_active' => true]
        );

        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'communication_method' => $this->faker->randomElement(CommunicationsMethodsEnum::cases()),
            'product_id' => $product->id,
            'date' => new Carbon($this->faker->date()),
            'topper_id' => $topper->id,
        ];

        $dto = OrderDTO::from($data);

        $case = app(StoreOrderCase::class);
        $order = $case->handle($dto);

        unset($data['topper_id']);

        $this->assertDatabaseHas('orders', $data);
        $this->assertDatabaseHas('additional_product_order', [
            'order_id' => $order->id,
            'additional_product_id' => $topper->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public function test_store_order_with_card_without_text()
    {
        $product = Product::factory()->create(['old_price' => null, 'is_active' => true,]);
        $card = AdditionalProduct::factory()->create(
            ['type' => AdditionalProductTypeEnum::Postcard, 'is_active' => true]
        );

        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'communication_method' => $this->faker->randomElement(CommunicationsMethodsEnum::cases()),
            'product_id' => $product->id,
            'date' => new Carbon($this->faker->date()),
            'card_id' => $card->id,
        ];

        $dto = OrderDTO::from($data);

        $case = app(StoreOrderCase::class);
        $order = $case->handle($dto);

        unset($data['card_id']);

        $this->assertDatabaseHas('orders', $data);
        $this->assertDatabaseHas('additional_product_order', [
            'order_id' => $order->id,
            'additional_product_id' => $card->id,
            'value' => null,
        ]);
    }

    /**
     * @throws Exception
     */
    public function test_store_order_with_card_with_text()
    {
        $product = Product::factory()->create(['old_price' => null, 'is_active' => true,]);
        $card = AdditionalProduct::factory()->create(
            ['type' => AdditionalProductTypeEnum::Postcard, 'is_active' => true]
        );
        $cardText = $this->faker->text(100);

        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'communication_method' => $this->faker->randomElement(CommunicationsMethodsEnum::cases()),
            'product_id' => $product->id,
            'date' => new Carbon($this->faker->date()),
            'card_id' => $card->id,
            'card_text' => $cardText
        ];

        $dto = OrderDTO::from($data);

        $case = app(StoreOrderCase::class);
        $order = $case->handle($dto);

        unset($data['card_id']);
        unset($data['card_text']);

        $this->assertDatabaseHas('orders', $data);
        $this->assertDatabaseHas('additional_product_order', [
            'order_id' => $order->id,
            'additional_product_id' => $card->id,
            'value' => $cardText,
        ]);
    }
}
