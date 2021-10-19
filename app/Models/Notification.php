<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Casts\Json;
use App\Http\Traits\CustomQuery;

class Notification extends Model {
    use CustomQuery;

    protected $fillable = ['user_id', 'notification_log_id', 'title', 'description', 'payload', 'read'];
    protected $hidden = ['user_id', 'notification_log_id'];
    protected $casts = [
        'payload' => Json::class,
        'read' => 'boolean'
    ];

    // list of properties queryable for datatable
    public static $queryable = ['title', 'description', 'payload', 'read'];
}
