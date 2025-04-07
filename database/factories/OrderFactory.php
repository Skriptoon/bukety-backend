<?php

namespace Database\Factories;
use App\Enums\CommunicationsMethodsEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'communication_method' => $this->faker->randomElement(CommunicationsMethodsEnum::cases()),
            'status' => $this->faker->randomElement(OrderStatusEnum::cases()),
            'product_id' => $product->id,
            'promo_code_id' => PromoCode::factory(),
            'price' => $product->price,
            'date' => $this->faker->date(),
        ];
    }
}
