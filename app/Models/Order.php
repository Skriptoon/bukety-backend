<?php

namespace App\Models;

use App\Enums\CommunicationsMethodsEnum;
use App\Enums\OrderStatusEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property CommunicationsMethodsEnum $communication_method
 * @property OrderStatusEnum $status
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product|null $product
 *
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCommunicationMethod($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereName($value)
 * @method static Builder|Order wherePhone($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereProductId($value)
 *
 * @mixin Eloquent
 */
class Order extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'communication_method',
        'status',
        'product_id',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
        'communication_method' => CommunicationsMethodsEnum::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
