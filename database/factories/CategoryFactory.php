<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/** @extends Factory<Category> */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'seo_description' => $this->faker->text(),
            'sort' => $this->faker->randomDigit(),
            'image' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(),
            'show_in_main' => $this->faker->boolean(),
            'is_hidden' => $this->faker->boolean(),
        ];
    }
}