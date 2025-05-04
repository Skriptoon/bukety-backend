<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductIngredient;
use App\UseCases\Product\Feeds\Strategies\FlowwowYmlFeedStrategy;
use App\UseCases\Product\Feeds\Strategies\VkYmlFeedStrategy;
use App\UseCases\Product\Feeds\Strategies\YandexYmlFeedStrategy;
use App\UseCases\Product\Feeds\YmlFeedGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YmlFeedTest extends TestCase
{
    use refreshDatabase;
    use WithFaker;

    /**
     * @throws Exception
     */
    public function testYandexFeedGeneration(): void
    {
        $category = Category::factory()->create(['is_active' => true]);
        $product = Product::factory()->create([
            'main_category_id' => $category->id,
            'price' => $this->faker->numberBetween(1000, 5000),
            'old_price' => $this->faker->numberBetween(5000, 7000),
            'is_active' => true,
            'gallery' => [$this->faker->imageUrl],
        ]);
        $product->categories()->attach($category);

        $generator = app(YmlFeedGenerator::class);
        $generator->addStrategy(new YandexYmlFeedStrategy());
        $generator->generate();

        $feed = new SimpleXMLElement(Storage::disk('public')->get('/feeds/yandex.yml') ?? '');
        $description = html_entity_decode(strip_tags($product->description)) . "\n\n" . $product->vk_description;

        $this->assertFileExists(Storage::disk('public')->path('/feeds/yandex.yml'));
        $this->assertEquals($description, (string)$feed->shop->offers->offer[0]->description);
        $this->assertYmlFeed($feed, $product);
    }

    /**
     * @throws Exception
     */
    public function testFlowwowFeedGeneration(): void
    {
        $ingredient = ProductIngredient::factory()->create();
        $category = Category::factory()->create(['is_active' => true]);
        $product = Product::factory()->create([
            'main_category_id' => $category->id,
            'price' => $this->faker->numberBetween(1000, 5000),
            'old_price' => $this->faker->numberBetween(5000, 7000),
            'is_active' => true,
            'gallery' => [$this->faker->imageUrl],
            'for_flowwow' => true,
        ]);
        $product->categories()->attach($category);
        $product->ingredients()->attach($ingredient, ['value' => 100, 'unit' => \App\Enums\UnitEnum::g]);

        $productIngredient = $product->ingredients->first();
        $productIngredient->save();

        $generator = app(YmlFeedGenerator::class);
        $generator->addStrategy(new FlowwowYmlFeedStrategy());
        $generator->generate();

        $feed = new SimpleXMLElement(Storage::disk('public')->get('/feeds/flowwow.yml') ?? '');
        $description = html_entity_decode(strip_tags($product->description)) . "\n\n";

        $this->assertFileExists(Storage::disk('public')->path('/feeds/flowwow.yml'));
        $this->assertEquals($description, (string)$feed->shop->offers->offer[0]->description);
        $this->assertEquals(100, (string)$feed->shop->offers->offer[0]->consist[0]);
        $this->assertEquals(
            \App\Enums\UnitEnum::g->label(),
            (string)$feed->shop->offers->offer[0]->consist[0]->attributes()->unit
        );
        $this->assertEquals(
            $ingredient->name,
            (string)$feed->shop->offers->offer[0]->consist[0]->attributes()->name
        );
        $this->assertEquals($product->weight / 1000, (string)$feed->shop->offers->offer[0]->weight);

        $paramMap = [
            'Ширина, См' => $product->width,
            'Высота, См' => $product->height,
        ];
        foreach ($feed->shop->offers->offer[0]->param as $param) {
            $paramName = (string)$param->attributes()->name;
            if (isset($paramMap[$paramName])) {
                $this->assertEquals($paramMap[$paramName], (string)$param);
            }
        }

        $this->assertYmlFeed($feed, $product);
    }

    /**
     * @throws Exception
     */
    public function testVkFeedGeneration(): void
    {
        $ingredient = ProductIngredient::factory()->create();
        $category = Category::factory()->create(['is_active' => true]);
        $product = Product::factory()->create([
            'main_category_id' => $category->id,
            'price' => $this->faker->numberBetween(1000, 5000),
            'old_price' => $this->faker->numberBetween(5000, 7000),
            'is_active' => true,
            'gallery' => [$this->faker->imageUrl],
            'vk_description' => 'vk_description',
        ]);

        $product->categories()->attach($category);

        $generator = app(YmlFeedGenerator::class);
        $generator->addStrategy(new VkYmlFeedStrategy());
        $generator->generate();

        $feed = new SimpleXMLElement(Storage::disk('public')->get('/feeds/vk.yml') ?? '');
        $description = html_entity_decode(
                strip_tags($product->description)
            ) . "\n\n" . $product->vk_description .
            "\n\nБукет можно забрать самовывозом или мы отправим его Вам Яндекс доставкой к нужному времени.\n\n"
            . "Цена - $product->price рублей действительна на " . date('d.m.Y') .
            " и может быть выше или ниже в зависимости от ваших пожеланий по составу и размера букета.\n\n"
            . 'Просто нажмите кнопку "Написать" и я с удовольствием приму ваш заказ.';

        $this->assertFileExists(Storage::disk('public')->path('/feeds/vk.yml'));
        $this->assertEquals($description, (string)$feed->shop->offers->offer[0]->description);
        $this->assertYmlFeed($feed, $product);
    }

    private function assertYmlFeed(SimpleXMLElement $feed, Product $product): void
    {
        $this->assertNotEquals('', (string)$feed->attributes()->date);
        $this->assertEquals(config('app.name'), (string)$feed->shop->name);
        $this->assertEquals(config('app.name'), (string)$feed->shop->company);
        $this->assertEquals(config('app.frontend_url'), (string)$feed->shop->url);
        $this->assertEquals($product->id, (string)$feed->shop->offers->offer[0]->attributes()->id);
        $this->assertEquals('true', (string)$feed->shop->offers->offer[0]->attributes()->available);
        $this->assertEquals($product->name, (string)$feed->shop->offers->offer[0]->name);
        $this->assertEquals($product->price, (string)$feed->shop->offers->offer[0]->price);
        $this->assertEquals('RUB', (string)$feed->shop->offers->offer[0]->currencyId);
        $this->assertEquals(
            config('app.frontend_url') . '/product/' . $product->slug,
            (string)$feed->shop->offers->offer[0]->url
        );
        $this->assertEquals($product->gallery_urls[0], (string)$feed->shop->offers->offer[0]->picture);
        $this->assertEquals($product->main_category_id, (string)$feed->shop->offers->offer[0]->categoryId);

        if ($product->old_price > 0) {
            $this->assertEquals($product->old_price, (string)$feed->shop->offers->offer[0]->oldprice);
        }

        $categories = Category::active()->get();
        foreach ($categories as $category) {
            $this->assertEquals($category->id, (string)$feed->shop->categories->category[0]->attributes()->id);
        }
    }
}