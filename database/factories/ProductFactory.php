<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
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
        $name = $this->faker->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'vk_description' => $this->faker->text(),
            'preview_description' => $this->faker->text(),
            'seo_description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 4, 6),
            'whom' => [],
            'occasion' => [],
            'image' => $this->faker->imageUrl(),
            'gallery' => [],
            'vk_url' => $this->faker->url(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
