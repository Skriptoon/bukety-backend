<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AdditionalProductTypeEnum;
use App\Models\AdditionalProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends Factory<AdditionalProduct>
 */
class AdditionalProductFactory extends Factory
{
    protected $model = AdditionalProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = uniqid(). '.webp';
        $image = UploadedFile::fake()->image(uniqid(), 1000, 1000);
        $image->storeAs('additional-products', $name, ['disk' => 'public']);

        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(AdditionalProductTypeEnum::class),
            'price' => $this->faker->numberBetween(1000, 10000),
            'image' => '/additional-products/' . $name,
            'is_active' => $this->faker->boolean(),
        ];
    }
}
