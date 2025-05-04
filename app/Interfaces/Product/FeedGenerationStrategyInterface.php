<?php

declare(strict_types=1);

namespace App\Interfaces\Product;

use Exception;

interface FeedGenerationStrategyInterface
{
    /**
     * @throws Exception
     */
    public function generate(): void;
}