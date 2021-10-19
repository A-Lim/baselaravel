<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model {

    protected $fillable = [
        'uuid', 'dashboard_id', 'category', 'name', 'type', 'settings', 'x', 'y',
        'rows', 'cols', 'dragEnabled', 'resizeEnabled', 'compactEnabled', 'maxItemRows', 
        'minItemRows', 'maxItemCols', 'minItemCols', 'minItemArea', 'maxItemArea'
    ];
    protected $hidden = [];
    protected $casts = [];

    public $timestamps = false;

    const TYPE_USERS_COUNT = 'users-count';
    const TYPE_ANNOUNCEMENTS_LISTING = 'announcements-listing';
    const TYPE_ANNOUNCEMENTS_COUNT = 'announcements-count';

    public function dashboard() {
        return $this->belongsTo(Dashboard::class);
    }
}
