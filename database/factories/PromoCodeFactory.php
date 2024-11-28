<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'promo_code' => strtoupper($this->faker->word()),
            'discount' => $this->faker->numberBetween(1, 99),
            'expired_at' => $this->faker->dateTime(now()->addDays(30)),
            'is_disposable' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
