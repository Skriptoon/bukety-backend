<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Enums\UnitEnum;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 
 *
 * @property int $product_ingredient_id
 * @property int $product_id
 * @property UnitEnum|null $unit
 * @property int|null $value
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductProductIngredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductProductIngredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductProductIngredient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductProductIngredient whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductProductIngredient whereProductIngredientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductProductIngredient whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductProductIngredient whereValue($value)
 * @mixin \Eloquent
 */
class ProductProductIngredient extends Pivot
{
    protected $casts = [
        'unit' => UnitEnum::class,
    ];
}