<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\CustomQuery;

class CustomerPackage extends Model
{
    use CustomQuery;

    protected $fillable = [
        'count', 
        'price', 
        'remarks', 
        'purchased_date', 
        'customer_id',
        'package_id',
        'created_by',
        'updated_by'
    ];
    public static $queryable = ['name', 'purchased_date'];
    public static $dateColumns = ['purchased_date'];
    public $timestamps = false;
    protected $table = 'customer_package';
}
