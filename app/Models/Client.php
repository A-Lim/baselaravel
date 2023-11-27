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
        'type',
    ];

    const TYPE_HOUSE_OWNER = 'house owner';
    const TYPE_SHOP_OWNER = 'shop owner';
    const TYPE_INTERIOR_DESIGNER = 'interior designer';
    const TYPE_CONTRACTOR = 'contractor';
    const TYPE_ARCHITECT = 'architect';
    const TYPE_DEVELOPER = 'developer';

    const TYPES = [
        self::TYPE_HOUSE_OWNER,
        self::TYPE_SHOP_OWNER,
        self::TYPE_INTERIOR_DESIGNER,
        self::TYPE_CONTRACTOR,
        self::TYPE_ARCHITECT,
        self::TYPE_DEVELOPER,
    ];

    public $timestamps = false;
    public static $queryable = ['name', 'ssm_no', 'phone', 'email', 'address'];
}
