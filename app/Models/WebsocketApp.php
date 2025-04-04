<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\WebsocketAppFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laravel\Reverb\Application;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use function config;

/**
 * Class WebsocketApp
 *
 * @author Vitalii Liubimov <vitalii@liubimov.org>
 * @package App\Models
 * @property Application $application
 * @property string $id
 * @property string $name
 * @property string $app_key
 * @property mixed $app_secret
 * @property int $ping_interval
 * @property array $allowed_origins
 * @property int $max_message_size
 * @property array|null $options
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static WebsocketAppFactory factory($count = null, $state = [])
 * @method static Builder<static>|WebsocketApp newModelQuery()
 * @method static Builder<static>|WebsocketApp newQuery()
 * @method static Builder<static>|WebsocketApp query()
 * @method static Builder<static>|WebsocketApp whereAllowedOrigins($value)
 * @method static Builder<static>|WebsocketApp whereAppKey($value)
 * @method static Builder<static>|WebsocketApp whereAppSecret($value)
 * @method static Builder<static>|WebsocketApp whereCreatedAt($value)
 * @method static Builder<static>|WebsocketApp whereId($value)
 * @method static Builder<static>|WebsocketApp whereMaxMessageSize($value)
 * @method static Builder<static>|WebsocketApp whereName($value)
 * @method static Builder<static>|WebsocketApp whereOptions($value)
 * @method static Builder<static>|WebsocketApp wherePingInterval($value)
 * @method static Builder<static>|WebsocketApp whereUpdatedAt($value)
 * @mixin Eloquent
 */
class WebsocketApp extends Model
{
    use HasApiTokens, HasSnowflakePrimary, HasFactory;

    protected $fillable = [
        'id',
        'name',
        'app_key',
        'app_secret',
        'ping_interval',
        'allowed_origins',
        'max_message_size',
        'options',
    ];

    protected $casts = [
        'id' => 'string',
        'app_key' => 'string',
        'app_secret' => 'encrypted',
        'activity_timeout',
        'allowed_origins' => 'array',
        'options' => 'json',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (WebsocketApp $application) {
            if (!$application->app_key) {
                $application->app_key = Str::random(32);
            }

            if (!$application->app_secret) {
                $application->app_secret = Str::random(32);
            }
        });
    }

    public function getPingIntervalAttribute(): int {
     return $this->attributes['ping_interval'] ?: config('reverb.apps.default.ping_interval');
    }

    public function getMaxMessageSizeAttribute(): int {
     return $this->attributes['max_message_size'] ?: config('reverb.apps.default.max_message_size');
    }

    public function getActivityTimeoutAttribute(): int {
        return config('reverb.apps.default.activity_timeout');
    }

    public function getApplicationAttribute(): Application
    {
        return new Application(
            $this->id,
            $this->app_key,
            $this->app_secret,
            $this->ping_interval ,
            $this->activity_timeout,
            $this->allowed_origins,
            $this->max_message_size,
            $this->options ?: []
        );
    }
}
