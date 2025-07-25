<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\DTO\Product\ProductDTO;
use App\Models\Product\Product;
use App\UseCases\Image\ImageOptimizeCase;
use App\UseCases\Product\Feeds\Strategies\FlowwowYmlFeedStrategy;
use App\UseCases\Product\Feeds\Strategies\VkYmlFeedStrategy;
use App\UseCases\Product\Feeds\Strategies\YandexYmlFeedStrategy;
use App\UseCases\Product\Feeds\YmlFeedGenerator;
use App\UseCases\Sitemap\SitemapGenerator;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Str;

readonly class StoreProductCase
{
    public function __construct(
        private ImageOptimizeCase $imageOptimizeCase,
        private SitemapGenerator $sitemapGenerator,
        private YmlFeedGenerator $ymlFeedGenerator,
        private UpdateProductIngredientsCase $updateProductIngredientsCase,
    ) {
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function handle(ProductDTO $data): void
    {
        $product = new Product([
            'name' => $data->name,
            'slug' => Str::slug($data->name),
            'main_category_id' => $data->main_category,
            'description' => $data->description,
            'vk_description' => $data->vk_description,
            'seo_description' => $data->seo_description,
            'price' => $data->price,
            'old_price' => $data->old_price,
            'is_active' => $data->is_active,
            'whom' => $data->whom,
            'occasion' => $data->occasion,
            'weight' => $data->weight,
            'width' => $data->width,
            'height' => $data->height,
            'for_flowwow' => $data->for_flowwow,
            'storage_conditions' => $data->storage_conditions,
        ]);

        if ($data->image) {
            $imagePath = $this->imageOptimizeCase->handle($data->image, 'product');
            $product->image = $imagePath;
        }

        if ($data->gallery) {
            $gallery = [];
            foreach ($data->gallery as $image) {
                $imagePath = $this->imageOptimizeCase->handle($image, 'product');
                $gallery[] = $imagePath;
            }

            $product->gallery = $gallery;
        }

        $product->save();
        $product->categories()->sync($data->categories);

        $this->updateProductIngredientsCase->handle($product, $data->ingredients, $data->ingredient_values, $data->ingredient_units);
        $this->sitemapGenerator->handle();
        $this->generateFeed();
    }

    private function generateFeed(): void
    {
        $this->ymlFeedGenerator->addStrategy(new VkYmlFeedStrategy());
        $this->ymlFeedGenerator->addStrategy(new YandexYmlFeedStrategy());
        $this->ymlFeedGenerator->addStrategy(new FlowwowYmlFeedStrategy());
        $this->ymlFeedGenerator->generate();
    }
}
