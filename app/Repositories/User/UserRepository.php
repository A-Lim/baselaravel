<?php
namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\Permission;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository {

    public function permissions(User $user) {
        if ($user->status == User::STATUS_LOCKED)
            return collect();

        $userGroups = UserGroup::whereHas('users', function($query) use ($user) {
            $query->where('user_id', '=', $user->id);
        })->get();


        $isAdmins = $userGroups->pluck('is_admin')->all();
        // check if there is an admin usergroups among the user's usergroup
        $hasAdmin = in_array(true, $isAdmins);

        // is has admin usergroup, return all permissions
        if ($hasAdmin)
            return Permission::pluck('code');

        $userGroupIds = $userGroups->pluck('id')->all();
        $permissions = Permission::whereHas('userGroups', function ($query) use ($userGroupIds) {
            $query->whereIn('usergroup_id', $userGroupIds);
        })->get()->pluck('code')->all();

        return $permissions;
    }

    public function list($data, $paginate = false) {
        $query = User::buildQuery($data);

        if (isset($data['id']) && is_array($data['id'])) {
            $ids = implode(',', $data['id']);
            $query->orderByRaw(DB::raw("FIELD(id,".$ids.") DESC"));
        }

        if ($paginate) {
            $limit = isset($data['limit']) ? $data['limit'] : 10;
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function count($conditions = null) {
        $query = User::query();

        if ($conditions)
            $query->where($conditions);

        return $query->count();
    }

    public function find($id) {
        return User::with('avatar')
            ->where('id', $id)
            ->firstOrFail();
    }

    public function findWithUserGroups($id) {
        return User::with(['usergroups', 'avatar'])->where('id', $id)->firstOrFail();
    }

    public function searchForOne($params) {
        return User::where($params)->first();
    }

    public function create($data) {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function update(User $user, $data) {
        if (!empty($data['password']))
            $data['password'] = Hash::make($data['password']);

        if (!empty($data['usergroups']))
            $user->userGroups()->sync($data['usergroups']);

        if (!empty($data['date_of_birth']))
            $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->toDateString();

        $user->fill($data);
        $user->save();
        return $user;
    }

    public function resetPassword(User $user, $password) {
        $user->password = $password;
        $user->setRememberToken(Str::random(60));
        $user->save();
    }

    public function saveAvatar(User $user, File $file) {
        $user->avatar()->save($file);
    }

    public function randomizePassword(User $user) {
        $random_password = Str::random(8);
        $user->password = Hash::make($random_password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        return $random_password;
    }
}
