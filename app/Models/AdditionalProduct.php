<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AdditionalProductTypeEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property AdditionalProductTypeEnum $type
 * @property string $price
 * @property string $image
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

    protected $guarded = [];

    protected $casts = [
        'type' => AdditionalProductTypeEnum::class,
    ];
}
