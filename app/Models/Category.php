<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\Category\IsMain;
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
 * @property string $description
 * @property string|null $image
 * @property string|null $seo_description
 * @property int|null $parent_id
 * @property int $sort
 * @property bool $is_active
 * @property bool $show_in_main
 * @property Carbon|null $created_at
 * @property string $slug
 * @property Carbon|null $updated_at
 * @property bool|null $is_hidden
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 * @property-read string|null $image_url
 * @property-read Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereImage($value)
 * @method static Builder|Category whereIsActive($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereSeoDescription($value)
 * @method static Builder|Category whereShowInMain($value)
 * @method static Builder|Category whereSort($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category active()
 * @method static Builder|Category filter(array $values, string $group = '__default')
 * @method static Builder|Category filterByQueryString(string $group = '__default')
 * @method static Builder|Category whereIsHidden($value)
 * @method static Builder|Category visible()
 * @method static CategoryFactory factory($count = null, $state = [])
 * @method static Builder|Category whereParentId($value)
 * @mixin Eloquent
 */
class Category extends Model
{
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

    protected array $filters = [
        IsMain::class,
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(__CLASS__, 'id', 'parent_id');
    }
}
