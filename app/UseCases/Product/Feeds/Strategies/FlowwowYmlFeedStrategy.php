<?php

declare(strict_types=1);

namespace App\UseCases\Product\Feeds\Strategies;

use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use SimpleXMLElement;
use Storage;

class FlowwowYmlFeedStrategy extends BaseFeedStrategy
{
    protected function getProducts(): Collection
    {
        return Product::active()
            ->whereForFlowwow(true)
            ->with('ingredients')
            ->get();
    }

    protected function getCategories(): Collection
    {
        return Category::active()
            ->get();
    }

    protected function getOfferCategories(Product $product): array
    {
        return [$product->main_category_id];
    }

    protected function getDescription(Product $product): string
    {
        $description = html_entity_decode(strip_tags($product->description)) . "\n \n";

        if ($product->storage_conditions) {
            $description .= html_entity_decode(strip_tags($product->storage_conditions)) . "\n \n ";
        } else {
            $description .= ' ';
        }

        return $description;
    }

    protected function getPath(): string
    {
        return Storage::disk('public')->path('feeds/flowwow.yml');
    }

    protected function addExtraChildren(SimpleXMLElement $offer, Product $product): void
    {
        $param = $offer->addChild('param', (string)$product->width);
        $param->addAttribute('name', 'Ширина, См');

        $param = $offer->addChild('param', (string)$product->height);
        $param->addAttribute('name', 'Высота, См');

        $offer->addChild('weight', (string)($product->weight / 1000));

        foreach ($product->ingredients as $ingredient) {
            /** @phpstan-ignore property.nonObject */
            $consist = $offer->addChild('consist', (string)$ingredient->pivot->value);
            $consist->addAttribute('name', $ingredient->name);
            /** @phpstan-ignore property.nonObject, method.nonObject */
            $consist->addAttribute('unit', $ingredient->pivot->unit->label());
        }
    }
}