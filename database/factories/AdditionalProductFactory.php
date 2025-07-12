<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AdditionalProductTypeEnum;
use App\Models\AdditionalProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of AdditionalProduct
 *
 * @extends Factory<TModel>
 */
class AdditionalProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = AdditionalProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(AdditionalProductTypeEnum::class),
            'price' => $this->faker->numberBetween(1000, 10000),
            'image' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
