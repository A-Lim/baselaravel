<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\CustomQuery;

class Announcement extends Model {
    use CustomQuery;

    protected $fillable = [
        'title', 'description', 'status', 'audience', 'audience_data_id', 
        'has_content', 'content', 
        'status', 'scheduled_publish_date', 'published_at',
        'push_notification', 'notification_sent',
        'created_by', 'updated_by'
    ];
    protected $hidden = [];
    protected $casts = [
        'has_content' => 'boolean',
        'push_notification' => 'boolean',
        'notification_sent' => 'boolean',
    ];

    // list of properties queryable for datatable
    public static $queryable = ['title', 'description', 'audience', 'status', 'scheduled_publish_date', 'published_at'];
    public static $dateColumns = ['scheduled_publish_date', 'published_at'];

    const AUDIENCE_ALL = 'all';
    const AUDIENCE_USERGROUPS = 'usergroups';

    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';

    const ACTION_PUBLISH = 'publish';
    const ACTION_UPDATE = 'update';
    const ACTION_SAVEDRAFT = 'savedraft';

    const AUDIENCES = [
        self::AUDIENCE_ALL,
        self::AUDIENCE_USERGROUPS
    ];

    const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_PENDING,
        self::STATUS_PUBLISHED,
    ];

    const ACTIONS = [
        self::ACTION_PUBLISH,
        self::ACTION_UPDATE,
        self::ACTION_SAVEDRAFT
    ];

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        self::creating(function($model) {
            // if status is not provided
            // set default to unverified
            if (empty($model->status)) {
                $model->status = self::STATUS_DRAFT;
            }
        });
    }

    public function image() {
        return $this->morphOne(File::class, 'fileable');
    }
}