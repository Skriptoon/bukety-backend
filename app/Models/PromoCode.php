<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PromoCodeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\PromoCode
 *
 * @property int $id
 * @property string $promo_code
 * @property int $discount
 * @property Carbon|null $expired_at
 * @property bool $is_disposable
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Order> $orders
 * @property-read int|null $orders_count
 * @method static PromoCodeFactory factory($count = null, $state = [])
 * @method static Builder<static>|PromoCode newModelQuery()
 * @method static Builder<static>|PromoCode newQuery()
 * @method static Builder<static>|PromoCode onlyTrashed()
 * @method static Builder<static>|PromoCode query()
 * @method static Builder<static>|PromoCode whereCreatedAt($value)
 * @method static Builder<static>|PromoCode whereDeletedAt($value)
 * @method static Builder<static>|PromoCode whereDiscount($value)
 * @method static Builder<static>|PromoCode whereExpiredAt($value)
 * @method static Builder<static>|PromoCode whereId($value)
 * @method static Builder<static>|PromoCode whereIsActive($value)
 * @method static Builder<static>|PromoCode whereIsDisposable($value)
 * @method static Builder<static>|PromoCode wherePromoCode($value)
 * @method static Builder<static>|PromoCode whereUpdatedAt($value)
 * @method static Builder<static>|PromoCode withTrashed()
 * @method static Builder<static>|PromoCode withoutTrashed()
 * @mixin Eloquent
 */
class PromoCode extends Model
{
    /**
     * @use HasFactory<PromoCodeFactory>
     */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'expired_at' => 'datetime',
        'bool' => 'boolean',
    ];

    /**
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
