<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model query()
 * @mixin \Eloquent
 */
class Model extends BaseModel
{
    use HasSnowflakePrimary;
}
