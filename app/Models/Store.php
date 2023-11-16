<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\CustomQuery;
use OwenIt\Auditing\Contracts\Auditable;

class Store extends Model implements Auditable {
    use SoftDeletes, CustomQuery, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'quotation_terms',
        'quotation_agreement',
        'invoice_terms',
    ];

    public $timestamps = false;
    public static $queryable = ['name', 'phone', 'email'];

    public function users() {
        return $this->belongsToMany(User::class, 'store_user_id', 'user_id', 'store_id'); 
    }
}
