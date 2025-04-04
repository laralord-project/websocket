<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Relations\BelongsTo};
use Illuminate\Support\Str;
use Storage;
use Symfony\Component\Mime\MimeTypes;

/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $creator
 * @property-read string $url
 * @property-read \App\Models\Profile|null $profile
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset query()
 * @mixin \Eloquent
 */
class Asset extends Model
{
    //    use HasFactory;

    public const DESTINATION_AVATAR = 'avatar';

    public const DESTINATION_LOGO = 'logo';

    public const DESTINATION_PRODUCT = 'product';

    public const DESTINATION_CATEGORY = 'category';

    public const DESTINATIONS = [
        self::DESTINATION_AVATAR,
        self::DESTINATION_LOGO,
        self::DESTINATION_PRODUCT,
        self::DESTINATION_CATEGORY,
    ];

    const STATUS_INIT = 'INIT';

    const STATUS_UPLOADED = 'UPLOADED';

    const STATUS_ERROR = 'ERROR';

    const STATUSES = [
        self::STATUS_INIT,
        self::STATUS_UPLOADED,
        self::STATUS_ERROR,
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'filename',
        'destination',
        'path',
        'status',
        'mime_type',
        'size',
    ];

    protected $casts = [
        'url' => 'string',
    ];

    protected $appends = ['url'];


    /**
     * @return BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function creator()
    {
        return $this->morphTo();
    }


    /**
     * @return bool
     */
    public function fileExists(): bool
    {
        return $this->path && Storage::disk('s3')->exists($this->path);
    }


    /**
     * @return string
     */
    public function guessExtension(): string
    {
        $originalExtensions = pathinfo($this->filename, PATHINFO_EXTENSION);

        $mimeTypes = new MimeTypes();
        $extensions = $mimeTypes->getExtensions($this->mime_type);

        if ($extensions) {
            return in_array($originalExtensions, $extensions) ? $originalExtensions : $extensions[0];
        }

        return $originalExtensions;
    }


    /**
     * @param $path
     *
     * @return string
     */
    public static function presignedUpload($path): string
    {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+10 minutes";

        $cmd = $client->getCommand('PutObject', [
            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
            'Key' => $path,
            'ACL' => 'public-read',
        ]);

        $request = $client->createPresignedRequest($cmd, $expiry);

        return (string) $request->getUri();
    }


    /**
     * Asset's tempirary Url
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        switch ($this->status) {
            case self::STATUS_INIT:
                return self::presignedUpload($this->path);
            case self::STATUS_ERROR:
                return '';
            case self::STATUS_UPLOADED:
            default:
                return $this->path;
            // return $this->path
            //     ? \Storage::temporaryUrl($this->path, now()->addMinutes(5))
            //     : '';
        }
    }


    /**
     * @param  string  $url
     * @param $destination
     * @param  Company|null  $company
     *
     * @return Asset
     */
    public static function createFromUrl(string $url, $destination, Company $company = null): Asset
    {
        $content = file_get_contents($url);
        $uuid = Str::uuid();

        $asset = new Asset([
            'destination' => $destination,
            'path' => "$destination/$uuid.jpg",
            'company_id' => $company->id ?? null,
        ]);

        $asset->filename = $url;

        Storage::disk('s3')->put($asset->path, $content);

        $asset->save();

        return $asset;
    }
}
