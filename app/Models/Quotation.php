<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\CustomQuery;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\QuotationItem;

class Quotation extends Model implements Auditable {
    use SoftDeletes, CustomQuery, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'store_id',
        'client_id',
        'version',
        'type', 
        'name',
        'cost',
        'costing_details',
        'total',
        'remarks',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static $queryable = ['store_id', 'type', 'name'];

    const STATUS_OBSOLETE = 'obsolete';
    const STATUS_CURRENT = 'current';

    const TYPE_SUPPLY_APPLY = 'supply apply';
    const TYPE_MATERIALS = 'materials';

    const TYPES = [
        self::TYPE_SUPPLY_APPLY,
        self::TYPE_MATERIALS
    ];

    const STATUSES = [
        self::STATUS_OBSOLETE,
        self::STATUS_CURRENT,
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function quotation_items() {
        return $this->hasMany(QuotationItem::class);
    }
}
