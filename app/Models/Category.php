<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\Category\IsMain;
use App\Models\Product\Product;
use Database\Factories\CategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Storage;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property string|null $seo_description
 * @property int $sort
 * @property bool $is_active
 * @property bool $show_in_main
 * @property bool $is_hidden
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $parent_id
 * @property-read Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read string|null $image_url
 * @property-read Collection<int, Product> $mainProducts
 * @property-read int|null $main_products_count
 * @property-read Category|null $parent
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 * @method static Builder<static>|Category active()
 * @method static CategoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|Category filter(mixed[] $values, string $group = '__default')
 * @method static Builder<static>|Category filterByQueryString(string $group = '__default')
 * @method static Builder<static>|Category newModelQuery()
 * @method static Builder<static>|Category newQuery()
 * @method static Builder<static>|Category query()
 * @method static Builder<static>|Category visible()
 * @method static Builder<static>|Category whereCreatedAt($value)
 * @method static Builder<static>|Category whereDescription($value)
 * @method static Builder<static>|Category whereId($value)
 * @method static Builder<static>|Category whereImage($value)
 * @method static Builder<static>|Category whereIsActive($value)
 * @method static Builder<static>|Category whereIsHidden($value)
 * @method static Builder<static>|Category whereName($value)
 * @method static Builder<static>|Category whereParentId($value)
 * @method static Builder<static>|Category whereSeoDescription($value)
 * @method static Builder<static>|Category whereShowInMain($value)
 * @method static Builder<static>|Category whereSlug($value)
 * @method static Builder<static>|Category whereSort($value)
 * @method static Builder<static>|Category whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Category extends Model
{
    /**
     * @use HasFactory<CategoryFactory>
     */
    use HasFactory;
    use HasFilters;

    protected $with = ['children'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'seo_description',
        'parent_id',
        'sort',
        'image',
        'is_active',
        'show_in_main',
        'is_hidden',
    ];

    /**
     * @var class-string[]
     */
    protected array $filters = [
        IsMain::class,
    ];

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return HasMany<Product, $this>
     */
    public function mainProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'main_category_id', 'id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /**
     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * @return HasMany<self, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasOne<self, $this>
     */
    public function parent(): HasOne
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }
}
