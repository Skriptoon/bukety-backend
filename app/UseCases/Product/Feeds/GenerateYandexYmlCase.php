<?php

declare(strict_types=1);

namespace App\UseCases\Product\Feeds;

use App\Models\Category;
use App\Models\Product;
use SimpleXMLElement;
use Storage;

class GenerateYandexYmlCase
{
    public function handle(): void
    {
        $productModels = Product::active()->get();
        $categoryModels = Category::active()->get();

        $xml = new SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?><yml_catalog date="' . date('Y-m-d H:i:s') . '"/>'
        );
        $shop = $xml->addChild('shop');
        $shop?->addChild('name', 'Букетница');
        $shop?->addChild('company', 'Букетница');
        $shop?->addChild('url', 'buketnitsa96.ru');

        $currencies = $shop?->addChild('currencies');
        $currency = $currencies?->addChild('currency');
        $currency?->addAttribute('id', 'RUB');
        $currency?->addAttribute('rate', '1');

        $categories = $shop?->addChild('categories');
        foreach ($categoryModels as $categoryModel) {
            $category = $categories?->addChild('category', $categoryModel->name);
            $category->addAttribute('id', (string)$categoryModel->id);
        }

        $offers = $shop?->addChild('offers');
        foreach ($productModels as $productModel) {
            $offer = $offers?->addChild('offer');

            $offer?->addAttribute('id', (string)$productModel->id);
            $offer?->addAttribute('available', 'true');

            $offer?->addChild('price', (string)$productModel->price);
            if ($productModel->old_price) {
                $offer?->addChild('oldprice', (string)$productModel->old_price);
            }
            $offer?->addChild('currencyId', 'RUB');

            $categoryId = $productModel->main_category_id;
            if ($categoryId === null) {
                $categoryId = $productModel->categories()->first()?->id;
            }
            $offer?->addChild('categoryId', (string)$categoryId);

            $offer?->addChild('name', $productModel->name);
            $offer?->addChild('url', config('app.frontend_url') . '/product/' . $productModel->slug);

            $description = html_entity_decode(strip_tags($productModel->description)) . "\n\n" . $productModel->vk_description;
            $offer?->addChild('description', $description);

            foreach ($productModel->gallery_urls as $gallery_url) {
                $offer?->addChild('picture', $gallery_url);
            }
        }

        Storage::disk('public')->makeDirectory('feeds');
        $xml->asXML(Storage::disk('public')->path('feeds/yandex.yml'));
    }
}
