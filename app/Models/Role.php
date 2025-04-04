<?php

namespace App\Models;

use App\Models\Traits\CompanyResource;
use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\{Builder, Factories\HasFactory, Relations\BelongsTo};
use Kra8\Snowflake\HasSnowflakePrimary;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\RoleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Role newModelQuery()
 * @method static Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role permission($permissions, $without = false)
 * @method static Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withoutPermission($permissions)
 * @mixin \Eloquent
 */
class Role extends SpatieRole implements RoleContract
{
    use HasFactory, HasSnowflakePrimary;

    const SUPER_ADMIN = 'super_admin';
    const ADMIN = 'admin';
    const COMPANY_ADMIN = 'company_admin';

    const SYSTEM_ROLES = [
        self::SUPER_ADMIN,
        self::ADMIN,
    ];

    const COMPANY_ROLES = [
        self::COMPANY_ADMIN,
    ];

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
        'updated_at',
        'created_at',
    ];
}
