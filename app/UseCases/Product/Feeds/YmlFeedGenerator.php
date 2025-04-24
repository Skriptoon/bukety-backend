<?php

declare(strict_types=1);

namespace App\UseCases\Product\Feeds;

use App\Interfaces\Product\FeedGenerationStrategyInterface;

class YmlFeedGenerator
{
    /** @var array<FeedGenerationStrategyInterface> */
    private array $strategies;

    public function addStrategy(FeedGenerationStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    public function generate(): void
    {
        foreach ($this->strategies as $strategy) {
            $strategy->generate();
        }
    }
}