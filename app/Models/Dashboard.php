<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model {

    protected $fillable = ['uuid', 'name', 'public', 'created_by', 'updated_by'];
    protected $hidden = [];
    protected $casts = [
        'public' => 'boolean'
    ];

    public function widgets() {
        return $this->hasMany(Widget::class);
    }
}
