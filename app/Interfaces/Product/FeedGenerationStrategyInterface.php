<?php

declare(strict_types=1);

namespace App\Interfaces\Product;

interface FeedGenerationStrategyInterface
{
    public function generate(): void;
}