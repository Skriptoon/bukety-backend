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
            $url = $xml->addChild('url');
            $url?->addChild('loc', $this->getFrontendUrl($staticPage));
            $url?->addChild('lastmod', date('c'));
            $url?->addChild('changefreq', 'weekly');
            $url?->addChild('priority', '0.8');
        }

        $categories = Category::active()->get();

        foreach ($categories as $category) {
            $url = $xml->addChild('url');
            $url?->addChild('loc', $this->getFrontendUrl($category->slug));
            $url?->addChild('lastmod', date('c'));
            $url?->addChild('changefreq', 'weekly');
            $url?->addChild('priority', '0.8');
        }

        $products = Product::active()->get();

        foreach ($products as $product) {
            $url = $xml->addChild('url');
            $url?->addChild('loc', $this->getFrontendUrl('product/' . $product->slug));
            $url?->addChild('lastmod', date('c'));
            $url?->addChild('changefreq', 'weekly');
            $url?->addChild('priority', '0.8');
        }

        $xml->asXML(Storage::path('/sitemap.xml'));
    }

    private function getFrontendUrl(string $path): string
    {
        return config('app.frontend_url') . '/' . $path;
    }
}