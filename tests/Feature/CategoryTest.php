<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DTO\Category\CategoryDTO;
use App\Models\Category;
use App\UseCases\Category\StoreCategoryCase;
use App\UseCases\Category\UpdateCategoryCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Storage;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function test_store_main_category(): void
    {
        $sitemapPath = Storage::path('sitemap.xml');
        Storage::delete('sitemap.xml');

        $categoryData = [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'seo_description' => $this->faker->sentence(),
            'image' => new UploadedFile($this->faker->image(), 'test.png'),
            'sort' => $this->faker->randomDigit(),
            'is_active' => $this->faker->boolean(),
            'show_in_main' => $this->faker->boolean(),
            'is_hidden' => $this->faker->boolean(),
        ];

        $dto = CategoryDTO::from($categoryData);

        /** @var StoreCategoryCase $case */
        $case = app(StoreCategoryCase::class);
        $case->handle($dto);

        $category = Category::firstOrFail();

        $this->assertFileExists($sitemapPath);
        $this->assertEquals($dto->name, $category->name);
        $this->assertEquals($dto->description, $category->description);
        $this->assertEquals($dto->seo_description, $category->seo_description);
        $this->assertFileExists(Storage::disk('public')->path($category->image));
        $this->assertEquals($dto->sort, $category->sort);
        $this->assertEquals($dto->is_active, $category->is_active);
        $this->assertEquals($dto->show_in_main, $category->show_in_main);
        $this->assertEquals($dto->is_hidden, $category->is_hidden);
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function test_update_main_category(): void
    {
        $category = Category::factory()->create();

        $sitemapPath = Storage::path('sitemap.xml');
        Storage::delete('sitemap.xml');

        $categoryData = [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'seo_description' => $this->faker->sentence(),
            'image' => new UploadedFile($this->faker->image(), 'test.png'),
            'sort' => $this->faker->randomDigit(),
            'is_active' => !$category->is_active,
            'show_in_main' => !$category->show_in_main,
            'is_hidden' => !$category->is_hidden,
        ];

        $dto = CategoryDTO::from($categoryData);

        /** @var UpdateCategoryCase $case */
        $case = app(UpdateCategoryCase::class);
        $case->handle($category, $dto);

        $this->assertFileExists($sitemapPath);
        $this->assertEquals($dto->name, $category->name);
        $this->assertEquals($dto->description, $category->description);
        $this->assertEquals($dto->seo_description, $category->seo_description);
        $this->assertFileExists(Storage::disk('public')->path($category->image));
        $this->assertEquals($dto->sort, $category->sort);
        $this->assertEquals($dto->is_active, $category->is_active);
        $this->assertEquals($dto->show_in_main, $category->show_in_main);
        $this->assertEquals($dto->is_hidden, $category->is_hidden);
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function test_store_child_category(): void
    {
        $sitemapPath = Storage::path('sitemap.xml');
        Storage::delete('sitemap.xml');

        $parentCategory = Category::factory()->create();

        $categoryData = [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'seo_description' => $this->faker->sentence(),
            'parent_id' => $parentCategory->id,
            'image' => new UploadedFile($this->faker->image(), 'test.png'),
            'sort' => $this->faker->randomDigit(),
            'is_active' => $this->faker->boolean(),
            'show_in_main' => $this->faker->boolean(),
            'is_hidden' => $this->faker->boolean(),
        ];

        $dto = CategoryDTO::from($categoryData);

        /** @var StoreCategoryCase $case */
        $case = app(StoreCategoryCase::class);
        $case->handle($dto);

        $category = Category::where('name', $dto->name)->first();
        $this->assertFileExists($sitemapPath);
        $this->assertEquals($dto->name, $category->name);
        $this->assertEquals($dto->description, $category->description);
        $this->assertEquals($dto->seo_description, $category->seo_description);
        $this->assertEquals($dto->parent_id, $category->parent_id);
        $this->assertFileExists(Storage::disk('public')->path($category->image));
        $this->assertEquals($dto->sort, $category->sort);
        $this->assertEquals($dto->is_active, $category->is_active);
        $this->assertEquals($dto->show_in_main, $category->show_in_main);
        $this->assertEquals($dto->is_hidden, $category->is_hidden);
    }

    public function test_update_child_category(): void
    {
        $category = Category::factory()->create();
        $parentCategory = Category::factory()->create();

        $sitemapPath = Storage::path('sitemap.xml');
        Storage::delete('sitemap.xml');

        $categoryData = [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'seo_description' => $this->faker->sentence(),
            'parent_id' => $parentCategory->id,
            'image' => new UploadedFile($this->faker->image(), 'test.png'),
            'sort' => $this->faker->randomDigit(),
            'is_active' => !$category->is_active,
            'show_in_main' => !$category->show_in_main,
            'is_hidden' => !$category->is_hidden,
        ];

        $dto = CategoryDTO::from($categoryData);

        /** @var UpdateCategoryCase $case */
        $case = app(UpdateCategoryCase::class);
        $case->handle($category, $dto);

        $this->assertFileExists($sitemapPath);
        $this->assertEquals($dto->name, $category->name);
        $this->assertEquals($dto->description, $category->description);
        $this->assertEquals($dto->seo_description, $category->seo_description);
        $this->assertEquals($dto->parent_id, $category->parent_id);
        $this->assertFileExists(Storage::disk('public')->path($category->image));
        $this->assertEquals($dto->sort, $category->sort);
        $this->assertEquals($dto->is_active, $category->is_active);
        $this->assertEquals($dto->show_in_main, $category->show_in_main);
        $this->assertEquals($dto->is_hidden, $category->is_hidden);
    }
}
