<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Storage;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $preview_description
 * @property string|null $seo_description
 * @property string $price
 * @property string $vk_url
 * @property string $image
 * @property array $gallery
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $image_url
 * @property string $gallery_urls
 * @property-read Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereGallery($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereImage($value)
 * @method static Builder|Product whereIsActive($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePreviewDescription($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereVkUrl($value)
 * @method static Builder|Product whereSeoDescription($value)
 * @method static Builder|Product active()
 * @method static Builder|Product filter(array $values, string $group = '__default')
 * @method static Builder|Product filterByQueryString(string $group = '__default')
 * @property array $whom
 * @property array $occasion
 * @method static Builder|Product whereOccasion($value)
 * @method static Builder|Product whereWhom($value)
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFilters;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'preview_description',
        'seo_description',
        'price',
        'whom',
        'occasion',
        'image',
        'vk_url',
        'is_active',
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'float',
        'whom' => 'array',
        'occasion' => 'array',
    ];

    protected array $filters = [
        \App\Filters\Product\Category::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image);
    }

    public function getGalleryUrlsAttribute(): array
    {
        $gallery = [];
        foreach ($this->gallery as $image) {
            $gallery[] = Storage::disk('public')->url($image);
        }

        return $gallery;
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }
}