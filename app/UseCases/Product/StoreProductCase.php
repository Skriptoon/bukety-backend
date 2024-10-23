<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\DTO\Product\ProductDTO;
use App\Models\Product;
use App\UseCases\Image\ImageOptimizeCase;
use App\UseCases\Sitemap\SitemapGenerator;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Str;

readonly class StoreProductCase
{
    public function __construct(
        private ImageOptimizeCase $imageOptimizeCase,
        private SitemapGenerator $sitemapGenerator,
        private GenerateVkYmlCase $generateVkYmlCase,
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
            'preview_description' => $data->preview_description,
            'seo_description' => $data->seo_description,
            'price' => $data->price,
            'is_active' => $data->is_active,
            'whom' => $data->whom,
            'occasion' => $data->occasion,
        ]);

        if ($data->image) {
            $imagePath = $this->imageOptimizeCase->handle($data->image->path(), 'product');
            $product->image = $imagePath;
        }

        if ($data->gallery) {
            $gallery = [];
            foreach ($data->gallery as $image) {
                if (is_string($image)) {
                    $gallery[] = $image;
                } else {
                    $imagePath = $this->imageOptimizeCase->handle($image->path(), 'product');
                    $gallery[] = $imagePath;
                }
            }

            $product->gallery = $gallery;
        }

        $product->save();
        $product->categories()->sync($data->categories);

        $this->updateProductIngredientsCase->handle($product, $data->ingredients);
        $this->sitemapGenerator->handle();
        $this->generateVkYmlCase->handle();
    }
}
