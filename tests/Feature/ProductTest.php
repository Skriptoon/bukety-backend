<?php

declare(strict_types=1);

use App\DTO\Product\ProductDTO;
use App\Enums\OccasionEnum;
use App\Enums\WhomEnum;
use App\Models\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductIngredient;
use App\UseCases\Product\StoreProductCase;
use App\UseCases\Product\UpdateProductCase;
use App\UseCases\Product\UpdateProductIngredientsCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function test_store_product()
    {
        Storage::delete('sitemap.xml');
        Storage::disk('public')->delete('feeds/vk.yml');
        Storage::disk('public')->delete('feeds/yandex.xml');

        $categories = Category::factory(4)->create();
        $whom = array_map(static fn(WhomEnum $whom): string => $whom->value, WhomEnum::cases());
        $occasion = array_map(static fn(OccasionEnum $occasion): string => $occasion->value, OccasionEnum::cases());

        $productData = [
            'name' => $this->faker->word,
            'main_category' => $categories[0]->id,
            'categories' => $categories->pluck('id')->toArray(),
            'description' => $this->faker->text(),
            'vk_description' => $this->faker->text(),
            'seo_description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2),
            'whom' => $this->faker->randomElements($whom),
            'occasion' => $this->faker->randomElements($occasion),
            'image' => [
                'file' => UploadedFile::fake()->image('test.png'),
            ],
            'gallery' => [['file' => UploadedFile::fake()->image('test.png'),]],
            'is_active' => $this->faker->boolean(),
            'old_price' => $this->faker->randomFloat(2),
            'ingredients' => ['тест'],
            'ingredient_units' => [$this->faker->randomElement(\App\Enums\UnitEnum::cases())],
            'ingredient_values' => [$this->faker->numberBetween(1, 100)],
            'weight' => $this->faker->numberBetween(1, 100),
            'width' => $this->faker->numberBetween(1, 100),
            'height' => $this->faker->numberBetween(1, 100),
            'for_flowwow' => $this->faker->boolean(),
        ];

        $dto = ProductDTO::from($productData);

        /** @var StoreProductCase $case */
        $case = app(StoreProductCase::class);

        $case->handle($dto);

        $product = Product::where('name', $productData['name'])->firstOrFail();
        $this->assertEquals($productData['name'], $product->name);
        $this->assertEquals($productData['main_category'], $product->mainCategory->id);
        $this->assertEquals($productData['categories'], $product->categories->pluck('id')->toArray());
        $this->assertEquals($productData['description'], $product->description);
        $this->assertEquals($productData['vk_description'], $product->vk_description);
        $this->assertEquals($productData['seo_description'], $product->seo_description);
        $this->assertEquals($productData['price'], $product->price);
        $this->assertEquals($productData['old_price'], $product->old_price);
        $this->assertEquals($productData['whom'], $product->whom);
        $this->assertEquals($productData['occasion'], $product->occasion);
        $this->assertEquals($productData['is_active'], $product->is_active);
        $this->assertGreaterThan(0, count($product->gallery));
        $this->assertGreaterThan(0, $product->ingredients->count());
        $this->assertFileExists(Storage::path('sitemap.xml'));
        $this->assertFileExists(Storage::disk('public')->path('feeds/vk.yml'));
        $this->assertFileExists(Storage::disk('public')->path('feeds/yandex.yml'));
        $this->assertFileExists(Storage::disk('public')->path('product/' . basename($product->image)));
        $this->assertFileExists(Storage::disk('public')->path('product/' . basename($product->gallery[0])));
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function test_update_product()
    {
        Storage::delete('sitemap.xml');
        Storage::disk('public')->delete('feeds/vk.yml');
        Storage::disk('public')->delete('feeds/yandex.xml');

        $categories = Category::factory(4)->create();
        $product = Product::factory()->create(['gallery' => []]);
        $whom = array_map(static fn(WhomEnum $whom): string => $whom->value, WhomEnum::cases());
        $occasion = array_map(static fn(OccasionEnum $occasion): string => $occasion->value, OccasionEnum::cases());

        $productData = [
            'name' => $this->faker->word,
            'main_category' => $categories[0]->id,
            'categories' => $categories->pluck('id')->toArray(),
            'description' => $this->faker->text(),
            'vk_description' => $this->faker->text(),
            'seo_description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2),
            'whom' => $this->faker->randomElements($whom),
            'occasion' => $this->faker->randomElements($occasion),
            'image' => [
                'file' => UploadedFile::fake()->image('test.png'),
            ],
            'gallery' => [['file' => UploadedFile::fake()->image('test.png')]],
            'is_active' => $this->faker->boolean(),
            'old_price' => $this->faker->randomFloat(2),
            'ingredients' => ['тест'],
            'ingredient_units' => [$this->faker->randomElement(\App\Enums\UnitEnum::cases())],
            'ingredient_values' => [$this->faker->numberBetween(1, 100)],
            'weight' => $this->faker->numberBetween(1, 100),
            'width' => $this->faker->numberBetween(1, 100),
            'height' => $this->faker->numberBetween(1, 100),
            'for_flowwow' => $this->faker->boolean(),
        ];

        $dto = ProductDTO::from($productData);

        /** @var UpdateProductCase $case */
        $case = app(UpdateProductCase::class);

        $case->handle($product, $dto);

        $product = Product::where('name', $productData['name'])->firstOrFail();
        $this->assertEquals($productData['name'], $product->name);
        $this->assertEquals($productData['main_category'], $product->mainCategory->id);
        $this->assertEquals($productData['categories'], $product->categories->pluck('id')->toArray());
        $this->assertEquals($productData['description'], $product->description);
        $this->assertEquals($productData['vk_description'], $product->vk_description);
        $this->assertEquals($productData['seo_description'], $product->seo_description);
        $this->assertEquals($productData['price'], $product->price);
        $this->assertEquals($productData['old_price'], $product->old_price);
        $this->assertEquals($productData['whom'], $product->whom);
        $this->assertEquals($productData['occasion'], $product->occasion);
        $this->assertEquals($productData['is_active'], $product->is_active);
        $this->assertGreaterThan(0, count($product->gallery));
        $this->assertGreaterThan(0, $product->ingredients->count());
        $this->assertFileExists(Storage::path('sitemap.xml'));
        $this->assertFileExists(Storage::disk('public')->path('feeds/vk.yml'));
        $this->assertFileExists(Storage::disk('public')->path('feeds/yandex.yml'));
        $this->assertFileExists(Storage::disk('public')->path('product/' . basename($product->image)));
        $this->assertFileExists(Storage::disk('public')->path('product/' . basename($product->gallery[0])));
    }

    public function test_update_ingredients()
    {
        $product = Product::factory()->create();
        $ingredient = ProductIngredient::factory()->create();

        /** @var UpdateProductIngredientsCase $case */
        $case = app(UpdateProductIngredientsCase::class);

        $case->handle(
            $product,
            ['Состав', 'Ингредиенты', $ingredient->name],
            [100, 100, 100],
            [\App\Enums\UnitEnum::g, \App\Enums\UnitEnum::g, \App\Enums\UnitEnum::g]
        );
        $ingredients = $product->ingredients()->pluck('name');

        $this->assertTrue($ingredients->contains('состав'));
        $this->assertTrue($ingredients->contains('ингредиенты'));
        $this->assertTrue($ingredients->contains($ingredient->name));
    }
}
