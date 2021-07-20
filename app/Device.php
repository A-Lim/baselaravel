<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model {

    protected $fillable = ['user_id', 'uuid', 'type', 'token'];
    protected $hidden = [];
    protected $casts = [];
    protected $appends = [];

    const TYPE_DESKTOP = 'desktop';
    const TYPE_MOBILE = 'mobile';

    const TYPES = [
        self::TYPE_DESKTOP,
        self::TYPE_MOBILE
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
