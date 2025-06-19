<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product\Product;
use App\UseCases\Sitemap\SitemapGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Storage;
use Tests\TestCase;

class SitemapGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_generator(): void
    {
        $sitemapPath = Storage::path('sitemap.xml');
        Storage::delete('sitemap.xml');

        $category = Category::factory()->create(['is_active' => true]);
        $product = Product::factory()->create(['is_active' => true]);

        $category->save();
        $product->save();

        /** @var SitemapGenerator $case */
        $case = app(SitemapGenerator::class);
        $case->handle();

        $this->assertFileExists($sitemapPath);

        $sitemap = Storage::get('sitemap.xml');

        $this->assertStringContainsString(config('app.frontend_url') . '/contacts', $sitemap);
        $this->assertStringContainsString(config('app.frontend_url') . '/delivery', $sitemap);
        $this->assertStringContainsString(config('app.frontend_url') . '/catalog', $sitemap);
        $this->assertStringContainsString(config('app.frontend_url') . '/' . $category->slug, $sitemap);
        $this->assertStringContainsString(config('app.frontend_url') . '/product/' . $product->slug, $sitemap);
        $this->assertStringContainsString('<priority>', $sitemap);
        $this->assertStringContainsString('<lastmod>', $sitemap);
        $this->assertStringContainsString('<changefreq>', $sitemap);
    }
}
