<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kra8\Snowflake\HasSnowflakePrimary;
use Spatie\Permission\Models\Permission as SpatiePermission;


/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SpatiePermission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\PermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class Permission extends SpatiePermission
{
    use HasFactory, HasSnowflakePrimary;

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];
    protected $visible = [
        'id',
        'name',
        'guard_name',
        'display_name',
        'description',
        'create_at',
        'updated_at',
    ];
}
