<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Http\Traits\CustomQuery;

class Customer extends Model implements Auditable
{
    use CustomQuery, \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'phone', 'email', 'remarks', 'created_by', 'updated_by'];
    public static $queryable = ['name', 'phone', 'email'];

    public function packages() {
        return $this->belongsToMany(Package::class, 'customer_package', 'customer_id', 'package_id'); 
    }
}
