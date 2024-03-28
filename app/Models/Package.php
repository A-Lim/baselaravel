<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Http\Traits\CustomQuery;

class Package extends Model implements Auditable {
    use CustomQuery, \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'description', 'default_count', 'default_price', 'created_by', 'updated_by'];
    public static $queryable = ['name'];
}
