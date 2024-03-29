<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

use App\Http\Traits\CustomQuery;

class UserGroup extends Model implements Auditable {
    use SoftDeletes, CustomQuery, Notifiable, \OwenIt\Auditing\Auditable;

    protected $table = 'usergroups';
    protected $fillable = ['name', 'code', 'status', 'deleted_at', 'created_by', 'updated_by'];
    protected $hidden = ['deleted_at', 'pivot', 'created_at', 'updated_at'];
    protected $casts = ['is_admin' => 'boolean'];

    // list of properties queryable for datatable
    public static $queryable = ['name', 'code', 'status', 'is_admin', 'deleted_at', 'created_by', 'updated_by'];
    public static $dateColumns = ['created_at', 'updated_at', 'deleted_at'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        self::creating(function($model) {
            // if status is not provided
            // set default to unverified
            if (empty($model->status)) {
                $model->status = self::STATUS_ACTIVE;
            }
        });
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_usergroup', 'usergroup_id', 'user_id'); 
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permission_usergroup', 'usergroup_id', 'permission_id'); 
    }

    public function givePermissions(array $ids) {
        $this->permissions()->sync($ids);
    }
}
