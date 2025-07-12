<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AdditionalProductTypeEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Storage;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property AdditionalProductTypeEnum $type
 * @property float $price
 * @property string $image
 * @property string $image_url
 * @property bool $is_active
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|AdditionalProduct newModelQuery()
 * @method static Builder<static>|AdditionalProduct newQuery()
 * @method static Builder<static>|AdditionalProduct onlyTrashed()
 * @method static Builder<static>|AdditionalProduct query()
 * @method static Builder<static>|AdditionalProduct whereCreatedAt($value)
 * @method static Builder<static>|AdditionalProduct whereDeletedAt($value)
 * @method static Builder<static>|AdditionalProduct whereId($value)
 * @method static Builder<static>|AdditionalProduct whereImage($value)
 * @method static Builder<static>|AdditionalProduct whereIsActive($value)
 * @method static Builder<static>|AdditionalProduct whereName($value)
 * @method static Builder<static>|AdditionalProduct wherePrice($value)
 * @method static Builder<static>|AdditionalProduct whereType($value)
 * @method static Builder<static>|AdditionalProduct whereUpdatedAt($value)
 * @method static Builder<static>|AdditionalProduct withTrashed()
 * @method static Builder<static>|AdditionalProduct withoutTrashed()
 * @mixin Eloquent
 */
class AdditionalProduct extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => AdditionalProductTypeEnum::class,
        'price' => 'float',
    ];

    /**
     * @return BelongsToMany<Order, $this>
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orders_additional_products');
    }

    public function getImageUrlAttribute(): string
    {

        return Storage::disk('public')->url($this->image);
    }
}
