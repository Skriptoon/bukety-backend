<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|StorageConditionsTemplate newModelQuery()
 * @method static Builder<static>|StorageConditionsTemplate newQuery()
 * @method static Builder<static>|StorageConditionsTemplate query()
 * @method static Builder<static>|StorageConditionsTemplate whereCreatedAt($value)
 * @method static Builder<static>|StorageConditionsTemplate whereId($value)
 * @method static Builder<static>|StorageConditionsTemplate whereName($value)
 * @method static Builder<static>|StorageConditionsTemplate whereUpdatedAt($value)
 * @method static Builder<static>|StorageConditionsTemplate whereValue($value)
 * @mixin Eloquent
 */
class StorageConditionsTemplate extends Model
{
    protected $guarded = ['id'];
}
