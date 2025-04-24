<?php

declare(strict_types=1);

namespace App\UseCases\Product\Feeds\Strategies;

use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Storage;

class YandexYmlFeedStrategy extends BaseFeedStrategy
{

    protected function getProducts(): Collection
    {
        return Product::active()
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
        return [$product->main_category_id ?? 0];
    }

    protected function getDescription(Product $product): string
    {
        return html_entity_decode(strip_tags($product->description)) . "\n\n" . $product->vk_description;
    }

    protected function getPath(): string
    {
        return Storage::disk('public')->path('feeds/yandex.yml');
    }
}
