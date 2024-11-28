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
 * @property-read Collection<int, Order> $orders
 * @property-read int|null $orders_count
 * @method static PromoCodeFactory factory($count = null, $state = [])
 * @method static Builder|PromoCode newModelQuery()
 * @method static Builder|PromoCode newQuery()
 * @method static Builder|PromoCode query()
 * @method static Builder|PromoCode whereCreatedAt($value)
 * @method static Builder|PromoCode whereDiscount($value)
 * @method static Builder|PromoCode whereExpiresAt($value)
 * @method static Builder|PromoCode whereId($value)
 * @method static Builder|PromoCode wherePromoCode($value)
 * @method static Builder|PromoCode whereUpdatedAt($value)
 * @method static Builder|PromoCode whereExpiredAt($value)
 * @method static Builder|PromoCode whereIsActive($value)
 * @method static Builder|PromoCode whereIsDisposable($value)
 * @mixin Eloquent
 */
class PromoCode extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'expired_at' => 'datetime',
        'bool' => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
