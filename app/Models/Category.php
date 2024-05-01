<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $image
 * @property string|null $seo_description
 * @property int $sort
 * @property bool $is_active
 * @property bool $show_in_main
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
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
 * @property string|null $slug
 * @method static Builder|Category whereSlug($value)
 * @mixin Eloquent
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'seo_description',
        'sort',
        'image',
        'is_active',
        'show_in_main',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}