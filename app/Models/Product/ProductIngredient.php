<?php

declare(strict_types=1);

namespace App\Models\Product;

use Database\Factories\Product\ProductIngredientFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductIngredient
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProductProductIngredient|null $pivot
 * @method static ProductIngredientFactory factory($count = null, $state = [])
 * @method static Builder<static>|ProductIngredient newModelQuery()
 * @method static Builder<static>|ProductIngredient newQuery()
 * @method static Builder<static>|ProductIngredient query()
 * @method static Builder<static>|ProductIngredient whereCreatedAt($value)
 * @method static Builder<static>|ProductIngredient whereId($value)
 * @method static Builder<static>|ProductIngredient whereName($value)
 * @method static Builder<static>|ProductIngredient whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductIngredient extends Model
{
    /**
     * @use HasFactory<ProductIngredientFactory>
     */
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
