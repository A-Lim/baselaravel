<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use App\Models\UserGroup;

class Permission extends Model {

    protected $fillable = ['code', 'label', 'module', 'description'];
    protected $hidden = ['pivot'];
    protected $casts = [];

    public function userGroups() {
        return $this->belongsToMany(UserGroup::class, 'permission_usergroup', 'permission_id', 'usergroup_id');
    }

    public static function clearCache() {
        return Cache::forget('permissions_with_usergroups');
    }

    public static function permissionUserGroupsCache() {
        return Cache::rememberForEver('permissions_with_usergroups', function() {
            return self::with('userGroups')->get();
        });
    }
}
