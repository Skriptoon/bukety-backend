<?php

declare(strict_types=1);

namespace App\UseCases\AdditionalProduct;

use App\DTO\AdditionalProduct\AdditionalProductDTO;
use App\Models\AdditionalProduct;
use App\UseCases\Image\ImageOptimizeCase;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

readonly class UpdateAdditionalProductCase
{
    public function __construct(private ImageOptimizeCase $imageOptimizeCase)
    {
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function handle(AdditionalProduct $additionalProduct, AdditionalProductDTO $data): void
    {
        $image = $additionalProduct->image;
        if ($data->image) {
            $image = $this->imageOptimizeCase->handle($data->image, 'additional_products');
        }

        $additionalProduct->update([
            'name' => $data->name,
            'type' => $data->type,
            'price' => $data->price,
            'image' => $image,
            'is_active' => $data->is_active
        ]);
    }
}