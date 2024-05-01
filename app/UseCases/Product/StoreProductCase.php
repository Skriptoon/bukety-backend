<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\DTO\Product\ProductDTO;
use App\Models\Product;
use App\UseCases\Image\ImageOptimizeCase;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Str;

readonly class StoreProductCase
{
    public function __construct(private ImageOptimizeCase $imageOptimizeCase)
    {
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
            'description' => $data->description,
            'preview_description' => $data->preview_description,
            'seo_description' => $data->seo_description,
            'price' => $data->price,
            'vk_url' => $data->vk_url,
            'is_active' => $data->is_active,
        ]);

        $imagePath = $this->imageOptimizeCase->handle($data->image->path(), 'product');
        $product->image = $imagePath;

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

        $product->save();
        $product->categories()->sync($data->categories);
    }
}