<?php

declare(strict_types=1);

namespace Database\Factories\Product;

use App\Enums\OccasionEnum;
use App\Enums\WhomEnum;
use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        $whom = array_map(static fn (WhomEnum $whom): string => $whom->value, WhomEnum::cases());
        $occasion = array_map(static fn (OccasionEnum $occasion): string => $occasion->value, OccasionEnum::cases());


        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'vk_description' => $this->faker->text(),
            'seo_description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, max: 10_000),
            'whom' => $whom,
            'occasion' => $occasion,
            'image' => $this->faker->imageUrl(),
            'gallery' => [],
            'is_active' => $this->faker->boolean(),
            'old_price' => $this->faker->randomFloat(2),
            'weight' => $this->faker->numberBetween(1, 1000),
            'width' => $this->faker->numberBetween(1, 1000),
            'height' => $this->faker->numberBetween(1, 1000),
            'for_flowwow' => $this->faker->boolean(),
            'main_category_id' => Category::factory(),
        ];
    }
}
