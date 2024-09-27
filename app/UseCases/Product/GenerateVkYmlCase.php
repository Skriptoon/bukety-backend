<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\Models\Category;
use App\Models\Product;
use SimpleXMLElement;
use Storage;

class GenerateVkYmlCase
{
    public function handle(): void
    {
        $productModels = Product::active()->get();
        $categoryModels = Category::active()->get();

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><yml_catalog/>');
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
            $category->addAttribute('id', (string) $categoryModel->id);
        }

        $offers = $shop?->addChild('offers');
        foreach ($productModels as $productModel) {
            $offer = $offers?->addChild('offer');

            $offer?->addAttribute('id', (string) $productModel->id);
            $offer?->addAttribute('available', 'true');

            $offer?->addChild('price', (string) $productModel->price);
            $offer?->addChild('currencyId', 'RUB');

            /** @var Category $category */
            foreach ($productModel->categories as $category) {
                $offer?->addChild('categoryId', (string) $category->id);
            }

            $offer?->addChild('name', $productModel->name);
            $offer?->addChild('url', config('app.frontend_url').'/product/'.$productModel->slug);

            $description = $productModel->preview_description."\n\n".$productModel->vk_description.
                "\n\nБукет можно забрать самовывозом или мы отправим его Вам Яндекс доставкой к нужному времени.\n\n"
                ."Цена - $productModel->price рублей действительна на ".date('d.m.Y').
                " и может быть выше или ниже в зависимости от ваших пожеланий по составу и размера букета.\n\n"
                .'Просто нажмите кнопку "Написать" и я с удовольствием приму ваш заказ.';
            $offer?->addChild('description', $description);

            foreach ($productModel->gallery_urls as $gallery_url) {
                $offer?->addChild('picture', $gallery_url);
            }
        }

        Storage::disk('public')->makeDirectory('feeds');
        $xml->asXML(Storage::disk('public')->path('feeds/vk.yml'));
    }
}
