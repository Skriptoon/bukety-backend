<?php

declare(strict_types=1);

namespace App\UseCases\Sitemap;

use App\Models\Category;
use App\Models\Product;
use SimpleXMLElement;
use Storage;

readonly class SitemapGenerator
{
    public function handle(): void
    {
        $staticPages = [
            'contacts',
            'delivery',
            'catalog',
        ];

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');

        foreach ($staticPages as $staticPage) {
            $this->addUrl($xml, $this->getFrontendUrl($staticPage));
        }

        $categories = Category::active()->get();

        foreach ($categories as $category) {
            $this->addUrl($xml, $this->getFrontendUrl($category->slug));
        }

        $products = Product::active()->get();

        foreach ($products as $product) {
            $this->addUrl($xml, $this->getFrontendUrl('product/'.$product->slug));
        }

        $xml->asXML(Storage::path('/sitemap.xml'));
    }

    private function addUrl(SimpleXMLElement $xml, string $url): void
    {
        $urlElement = $xml->addChild('url');

        $urlElement->addChild('loc', $url);
        $urlElement->addChild('lastmod', date('c'));
        $urlElement->addChild('changefreq', 'weekly');
        $urlElement->addChild('priority', '0.8');
    }

    private function getFrontendUrl(string $path): string
    {
        return config('app.frontend_url').'/'.$path;
    }
}
