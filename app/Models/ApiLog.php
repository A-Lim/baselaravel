<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\CustomQuery;
use Illuminate\Database\Eloquent\MassPrunable;

class ApiLog extends Model {
    use CustomQuery, MassPrunable;

    protected $fillable = ['user_id', 'method', 'url', 'ip', 'user_agent', 'header', 'request_data', 'response_data', 'status'];
    protected $hidden = [];
    protected $casts = [];

    // automatically purge data after x amount of days
    public function prunable() {
        return static::where('created_at', '<=', now()->subDays(env('CLEAR_OLD_LOGS_DAYS')));
    }
}
