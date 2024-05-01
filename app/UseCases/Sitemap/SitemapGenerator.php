<?php

declare(strict_types=1);

namespace App\UseCases\Sitemap;

class SitemapGenerator
{
    public function handle()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
       $url = $xml->addChild('url');
    }
}