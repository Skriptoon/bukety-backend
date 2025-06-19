<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Filters\Product\Category as CategoryFilter;
use App\Filters\Product\Ids;
use App\Filters\Product\Name;
use App\Models\Category;
use App\Models\Order;
use Database\Factories\Product\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property string|null $seo_description
 * @property float $price
 * @property string $image
 * @property array<array-key, mixed> $gallery
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array<array-key, mixed> $whom
 * @property array<array-key, mixed> $occasion
 * @property string|null $vk_description
 * @property int $main_category_id
 * @property float|null $old_price
 * @property int|null $width
 * @property int|null $height
 * @property int|null $weight
 * @property bool|null $for_flowwow
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @property-read array<string> $gallery_urls
 * @property-read string $image_url
 * @property-read ProductProductIngredient|null $pivot
 * @property-read Collection<int, ProductIngredient> $ingredients
 * @property-read int|null $ingredients_count
 * @property-read Category $mainCategory
 * @method static Builder<static>|Product active()
 * @method static ProductFactory factory($count = null, $state = [])
 * @method static Builder<static>|Product filter(mixed[] $values, string $group = '__default')
 * @method static Builder<static>|Product filterByQueryString(string $group = '__default')
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product onlyTrashed()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereDeletedAt($value)
 * @method static Builder<static>|Product whereDescription($value)
 * @method static Builder<static>|Product whereForFlowwow($value)
 * @method static Builder<static>|Product whereGallery($value)
 * @method static Builder<static>|Product whereHeight($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereImage($value)
 * @method static Builder<static>|Product whereIsActive($value)
 * @method static Builder<static>|Product whereMainCategoryId($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product whereOccasion($value)
 * @method static Builder<static>|Product whereOldPrice($value)
 * @method static Builder<static>|Product wherePrice($value)
 * @method static Builder<static>|Product whereSeoDescription($value)
 * @method static Builder<static>|Product whereSlug($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 * @method static Builder<static>|Product whereVkDescription($value)
 * @method static Builder<static>|Product whereWeight($value)
 * @method static Builder<static>|Product whereWhom($value)
 * @method static Builder<static>|Product whereWidth($value)
 * @method static Builder<static>|Product withTrashed()
 * @method static Builder<static>|Product withoutTrashed()
 * @mixin Eloquent
 */
class Product extends Model
{
    /**
     * @use HasFactory<ProductFactory>
     */
    use HasFactory;
    use HasFilters;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'main_category_id',
        'description',
        'vk_description',
        'seo_description',
        'price',
        'old_price',
        'whom',
        'occasion',
        'image',
        'gallery',
        'is_active',
        'weight',
        'width',
        'height',
        'for_flowwow',
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'float',
        'old_price' => 'float',
        'whom' => 'array',
        'occasion' => 'array',
        'is_active' => 'bool',
    ];

    /**
     * @var array<class-string>
     */
    protected array $filters = [
        CategoryFilter::class,
        Name::class,
        Ids::class,
    ];

    /**
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsToMany<ProductIngredient, $this, ProductProductIngredient>
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(ProductIngredient::class)
            ->using(ProductProductIngredient::class)
            ->withPivot(['unit', 'value']);
    }

    /** @return BelongsTo<Order, $this> */
    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image);
    }

    /**
     * @return array<string>
     */
    public function getGalleryUrlsAttribute(): array
    {
        $gallery = [];
        foreach ($this->gallery as $image) {
            $gallery[] = Storage::disk('public')->url($image);
        }

        return $gallery;
    }

    /**
     * @param Builder<self> $builder
     * @return Builder<self>
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }
}
