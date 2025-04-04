<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kra8\Snowflake\HasSnowflakePrimary;


/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language query()
 * @mixin \Eloquent
 */
class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'native_name',
        'lang_iso',
        'lang_iso2',
        'lang_tag',
        'flag',
        'enabled',
    ];
}
