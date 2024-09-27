<?php

declare(strict_types=1);

namespace App\UseCases\Category;

use App\DTO\Category\CategoryDTO;
use App\Models\Category;
use App\UseCases\Image\ImageOptimizeCase;
use App\UseCases\Sitemap\SitemapGenerator;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Str;

readonly class StoreCategoryCase
{
    public function __construct(
        private ImageOptimizeCase $imageOptimize,
        private SitemapGenerator $sitemapGenerator,
    ) {
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function handle(CategoryDTO $data): void
    {
        $image = null;
        if ($data->image) {
            $image = $this->imageOptimize->handle($data->image->path(), 'category');
        }

        Category::create([
            'name' => $data->name,
            'slug' => Str::slug($data->name),
            'description' => $data->description,
            'seo_description' => $data->seo_description,
            'parent_id' => $data->parent_id,
            'image' => $image,
            'sort' => $data->sort,
            'is_active' => $data->is_active,
            'show_in_main' => $data->show_in_main,
            'is_hidden' => $data->is_hidden,
        ]);

        $this->sitemapGenerator->handle();
    }
}
