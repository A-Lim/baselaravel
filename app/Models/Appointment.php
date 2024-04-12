<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Http\Traits\CustomQuery;

class Appointment extends Model implements Auditable {
    use CustomQuery, \OwenIt\Auditing\Auditable;

    protected $fillable = ['customer_id', 'remarks', 'created_at', 'created_by', 'updated_by'];
    public static $queryable = ['created_at'];
    public static $dateColumns = ['created_at'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function packages() {
        return $this->belongsToMany(CustomerPackage::class, 'appointment_customerpackage', 'appointment_id', 'customerpackage_id'); 
    }
}
