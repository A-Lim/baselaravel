<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Http\Traits\CustomQuery;

class CustomerPackage extends Model implements Auditable
{
    use CustomQuery, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'count', 
        'price', 
        'remarks', 
        'purchased_at', 
        'status',
        'customer_id',
        'package_id',
        'created_by',
        'updated_by'
    ];
    public static $queryable = ['name', 'status', 'purchased_at'];
    public static $dateColumns = ['purchased_at'];
    public $timestamps = false;
    protected $table = 'customer_package';

    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_COMPLETED,
    ];
}
