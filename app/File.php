<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model {

    protected $fillable = ['name', 'path', 'folder', 'extension', 'disk_type', 'visibility', 'fileable_id', 'fileable_type'];
    protected $hidden = ['path', 'folder', 'disk_type', 'visibility', 'fileable_id', 'fileable_type', 'created_at', 'updated_at'];
    protected $casts = [];
    protected $appends = ['url'];

    const DISK_TYPE_PUBLIC = 'public';
    const DISK_TYPE_S3 = 's3';

    const DISK_TYPES = [
        self::DISK_TYPE_PUBLIC,
        self::DISK_TYPE_S3
    ];

    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVATE = 'private';

    const VISIBILITIES = [
        self::VISIBILITY_PUBLIC,
        self::VISIBILITY_PRIVATE
    ];

    public function getUrlAttribute() {
        if ($this->disk_type == self::DISK_TYPE_S3)
            return Storage::url($this->path);

        return url(Storage::url($this->path));
    }

    public function fileable() {
        return $this->morphTo();
    }
}
