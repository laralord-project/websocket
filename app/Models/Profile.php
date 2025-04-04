<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Storage;

/**
 * 
 *
 * @property-read \App\Models\Asset|null $avatar
 * @property-read mixed $avatar_url
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @mixin \Eloquent
 */
class Profile extends Model
{
    use HasFactory;

    public const UI_SCHEME_LIGHT = 'light';
    public const UI_SCHEME_DARK = 'dark';
    public const UI_SCHEMES = [
        self::UI_SCHEME_LIGHT,
        self::UI_SCHEME_DARK,
    ];


    protected $fillable = [
        'first_name',
        'last_name',
        'avatar_id',
        'language_id',
        'ui_scheme',
    ];


    /**
     * @return BelongsTo
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }

        return Storage::temporaryUrl($this->avatar->path, now()->addMinutes(5));
    }
}
