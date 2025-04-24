<?php

namespace App\UseCases\Product\Feeds\Strategies;

use App\Interfaces\Product\FeedGenerationStrategyInterface;
use App\Models\Category;
use App\Models\Product\Product;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use SimpleXMLElement;
use Storage;

abstract class BaseFeedStrategy implements FeedGenerationStrategyInterface
{
    private SimpleXMLElement $shop;

    /**
     * @return Collection<int, Product>
     */
    abstract protected function getProducts(): Collection;

    /**
     * @return Collection<int, Category>
     */
    abstract protected function getCategories(): Collection;

    /**
     * @param Product $product
     * @return array<int>
     */
    abstract protected function getOfferCategories(Product $product): array;

    abstract protected function getDescription(Product $product): string;

    abstract protected function getPath(): string;

    /**
     * @throws Exception
     */
    public function generate(): void
    {
        $xml = new SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?><yml_catalog date="' . date('Y-m-d H:i:s') . '"/>'
        );

        /** @var SimpleXMLElement $shop */
        $shop = $xml->addChild('shop');
        $shop->addChild('name', config('app.name'));
        $shop->addChild('company', config('app.name'));
        $shop->addChild('url', config('app.url'));

        $this->shop = $shop;

        $this->addCategories();
        $this->addOffers();

        Storage::disk('public')->makeDirectory('feeds');
        $xml->asXML($this->getPath());
    }

    protected function addCategories(): void
    {
        $categoryModels = $this->getCategories();

        $categories = $this->shop->addChild('categories');
        foreach ($categoryModels as $categoryModel) {
            $category = $categories?->addChild('category', $categoryModel->name);
            $category->addAttribute('id', (string)$categoryModel->id);
        }
    }

    protected function addOffers(): void
    {
        $products = $this->getProducts();

        $offers = $this->shop->addChild('offers');
        foreach ($products as $productModel) {
            $offer = $offers?->addChild('offer');

            $offer?->addAttribute('id', (string)$productModel->id);
            $offer?->addAttribute('available', 'true');

            $offer?->addChild('name', $productModel->name);
            $offer?->addChild('url', config('app.frontend_url') . '/product/' . $productModel->slug);
            $offer?->addChild('price', (string)$productModel->price);
            if ($productModel->old_price) {
                $offer?->addChild('oldprice', (string)$productModel->old_price);
            }
            $offer?->addChild('currencyId', 'RUB');

            $offer?->addChild('description', $this->getDescription($productModel));

            $categoryIds = $this->getOfferCategories($productModel);
            foreach ($categoryIds as $categoryId) {
                $offer?->addChild('categoryId', (string)$categoryId);
            }

            foreach ($productModel->gallery_urls as $gallery_url) {
                $offer?->addChild('picture', $gallery_url);
            }

            $this->addExtraChildren($offer, $productModel);
        }
    }

    protected function addExtraChildren(SimpleXMLElement $offer, Product $product): void
    {
    }
}