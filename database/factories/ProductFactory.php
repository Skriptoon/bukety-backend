<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OccasionEnum;
use App\Enums\WhomEnum;
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
        $whom = array_map(static fn (WhomEnum $whom): string => $whom->value, WhomEnum::cases());
        $occasion = array_map(static fn (OccasionEnum $occasion): string => $occasion->value, OccasionEnum::cases());

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'vk_description' => $this->faker->text(),
            'preview_description' => $this->faker->text(),
            'seo_description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2),
            'whom' => $whom,
            'occasion' => $occasion,
            'image' => $this->faker->imageUrl(),
            'gallery' => [],
            'is_active' => $this->faker->boolean(),
            'old_price' => $this->faker->randomFloat(2),
        ];
    }
}
