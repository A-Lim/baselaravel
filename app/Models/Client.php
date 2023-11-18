<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\CustomQuery;

class Client extends Model {
    use CustomQuery;

    protected $fillable = [
        'name',
        'ssm_no',
        'email',
        'phone',
        'address',
    ];

    public $timestamps = false;
    public static $queryable = ['name', 'ssm_no', 'phone', 'email', 'address'];
}
