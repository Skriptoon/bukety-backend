<?php

declare(strict_types=1);

namespace App\UseCases\Product\Feeds\Strategies;

use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Storage;

class VkYmlFeedStrategy extends BaseFeedStrategy
{
    protected function getProducts(): Collection
    {
        return Product::active()
            ->with('categories')
            ->get();
    }

    protected function getCategories(): Collection
    {
        return Category::active()
            ->whereHas('products')
            ->get();
    }

    protected function getOfferCategories(Product $product): array
    {
        return $product->categories->pluck('id')->toArray();
    }

    protected function getDescription(Product $product): string
    {
        return html_entity_decode(
                strip_tags($product->description)
            ) . "\n\n" . $product->vk_description .
            "\n\nБукет можно забрать самовывозом или мы отправим его Вам Яндекс доставкой к нужному времени.\n\n"
            . "Цена - $product->price рублей действительна на " . date('d.m.Y') .
            " и может быть выше или ниже в зависимости от ваших пожеланий по составу и размера букета.\n\n"
            . 'Просто нажмите кнопку "Написать" и я с удовольствием приму ваш заказ.';
    }

    protected function getPath(): string
    {
        return Storage::disk('public')->path('feeds/vk.yml');
    }
}
