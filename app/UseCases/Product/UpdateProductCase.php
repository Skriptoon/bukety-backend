<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\DTO\Product\ProductDTO;
use App\Models\Product;
use App\UseCases\Image\ImageOptimizeCase;
use App\UseCases\Product\Feeds\GenerateVkYmlCase;
use App\UseCases\Product\Feeds\GenerateYandexYmlCase;
use App\UseCases\Sitemap\SitemapGenerator;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Storage;
use Str;

readonly class UpdateProductCase
{
    public function __construct(
        private ImageOptimizeCase $imageOptimizeCase,
        private SitemapGenerator $sitemapGenerator,
        private GenerateVkYmlCase $generateVkYmlCase,
        private GenerateYandexYmlCase $generateYandexYmlCase,
        private UpdateProductIngredientsCase $updateProductIngredientsCase,
    ) {
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function handle(Product $product, ProductDTO $data): void
    {
        $product->fill([
            'name' => $data->name,
            'main_category_id' => $data->main_category,
            'description' => $data->description,
            'vk_description' => $data->vk_description,
            'seo_description' => $data->seo_description,
            'price' => $data->price,
            'old_price' => $data->old_price,
            'slug' => Str::slug($data->name),
            'whom' => $data->whom,
            'occasion' => $data->occasion,
            'is_active' => $data->is_active,
        ]);

        if ($data->image !== null) {
            Storage::disk('public')->delete($product->image);

            $imagePath = $this->imageOptimizeCase->handle($data->image->path(), 'product');
            $product->image = $imagePath;
        }

        $gallery = [];
        $savedFiles = [];
        foreach ($data->gallery as $image) {
            if (is_string($image)) {
                $gallery[] = $image;
                $savedFiles[] = $image;
            } else {
                $imagePath = $this->imageOptimizeCase->handle($image->path(), 'product');
                $gallery[] = $imagePath;
            }
        }

        $deletedFiles = array_diff($product->gallery, $savedFiles);
        Storage::disk('public')->delete($deletedFiles);

        $product->gallery = $gallery;

        $product->save();
        $product->categories()->withoutGlobalScope('visible')->sync($data->categories);

        $this->updateProductIngredientsCase->handle($product, $data->ingredients);
        $this->sitemapGenerator->handle();
        $this->generateVkYmlCase->handle();
        $this->generateYandexYmlCase->handle();
    }
}
