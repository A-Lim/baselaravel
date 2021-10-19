<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\Json;

class WidgetType extends Model {

    protected $guard = [];
    protected $hidden = [];
    protected $casts = [
        'icon' => Json::class,
        'settings' => Json::class,
        'configurations' => Json::class,
    ];
}
