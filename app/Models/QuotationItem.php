<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quotation;

class QuotationItem extends Model {

    protected $fillable = [
        'quotation_id',
        'sequence', 
        'description',
        'quantity',
        'unit',
        'total',
    ];

    public $timestamps = false;

    const TYPE_SQFT = 'sqft';
    const TYPE_M2 = 'm2';

    const TYPES = [
        self::TYPE_SQFT,
        self::TYPE_M2,
    ];

    public function quotation() {
        return $this->belongsTo(Quotation::class);
    }
}
