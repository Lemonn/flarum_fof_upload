<?php

namespace FoF\Upload;

use Flarum\Database\AbstractModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $upload_id
 * @property string $file_id
 * @property int $image_width
 * @property int $image_height
 * @property File $file
 */
class ImageMetadata extends AbstractModel
{
    protected $table = 'fof_upload_image_metadata';

    protected $primaryKey = 'upload_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'file_id',
        'image_width',
        'image_height',
    ];

    public static function byUuid(string $uuid): Builder
    {
        return static::query()
            ->where('uuid', $uuid);
    }

    public static function byFile($file): Builder|Model|null
    {
        if (!$file) {
            return null;
        }

        return static::query()->where('upload_id', $file->id)->first();
    }

    /**
     * Relation to the File model
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'upload_id', 'id');
    }

    /**
     * Static helper to find a metadata row by upload_id
     */
    public static function byUploadId(int $uploadId): ?self
    {
        return static::query()->where('upload_id', $uploadId)->first();
    }
}
