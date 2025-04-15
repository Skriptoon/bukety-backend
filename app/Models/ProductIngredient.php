<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProductIngredientFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductIngredient
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProductIngredient newModelQuery()
 * @method static Builder|ProductIngredient newQuery()
 * @method static Builder|ProductIngredient query()
 * @method static Builder|ProductIngredient whereCreatedAt($value)
 * @method static Builder|ProductIngredient whereId($value)
 * @method static Builder|ProductIngredient whereName($value)
 * @method static Builder|ProductIngredient whereUpdatedAt($value)
 * @method static ProductIngredientFactory factory($count = null, $state = [])
 * @mixin Eloquent
 */
class ProductIngredient extends Model
{
    /**
     * @use HasFactory<ProductIngredientFactory>
     */
    use HasFactory;

    protected $guarded = [];
}
