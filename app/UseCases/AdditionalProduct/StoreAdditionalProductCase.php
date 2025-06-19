<?php

declare(strict_types=1);

namespace App\UseCases\AdditionalProduct;

use App\DTO\AdditionalProduct\AdditionalProductDTO;
use App\Models\AdditionalProduct;
use App\UseCases\Image\ImageOptimizeCase;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

readonly class StoreAdditionalProductCase
{
    public function __construct(private ImageOptimizeCase $imageOptimizeCase)
    {
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function handle(AdditionalProductDTO $data): void
    {
        $image = null;
        if ($data->image !== null) {
            $image = $this->imageOptimizeCase->handle($data->image, 'additional-products');
        }

        AdditionalProduct::create([
            'name' => $data->name,
            'type' => $data->type,
            'price' => $data->price,
            'image' => $image,
            'is_active' => $data->is_active
        ]);
    }
}