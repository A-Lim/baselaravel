<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transaction extends Model implements Auditable {
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['customer_id', 'amount', 'remarks', 'created_at', 'created_by', 'updated_by'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function packages() {
        return $this->belongsToMany(CustomerPackage::class, 'customerpackage_transaction', 'transaction_id', 'customerpackage_id')
            ->withPivot('amount'); 
    }
}
