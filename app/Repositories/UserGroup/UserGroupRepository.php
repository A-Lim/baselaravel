<?php
namespace App\Repositories\UserGroup;

use DB;
use App\Models\User;
use App\Models\UserGroup;
use Carbon\Carbon;

class UserGroupRepository implements IUserGroupRepository {
    /**
     * {@inheritdoc}
     */
    public function codeExists($code, $userGroupId = null) {
        $conditions = [['code', '=', $code]];
        if ($userGroupId != null)
            array_push($conditions, ['id', '<>', $userGroupId]);

        return UserGroup::where($conditions)->exists();
    }

     /**
     * {@inheritdoc}
     */
    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = UserGroup::buildQuery($data)
            ->withCount('users');

        if (isset($data['includes'])) {
            $split = explode(':', $data['includes']);
            $type = $split[0];
            $values = $split[1];

            if ($values) {
                $query->orderByRaw(DB::raw("FIELD(".$type.",".$values.") DESC"));
                $limit += count(explode(',', $split[1]));
            }
        }

        if ($paginate) 
            return $query->paginate($limit);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function listUsers(UserGroup $userGroup, $data, $paginate = false) {
        $query = User::buildQuery($data)
            ->join('user_usergroup', 'user_usergroup.user_id', 'users.id')
            ->where('user_usergroup.usergroup_id', $userGroup->id)
            ->orderBy('id', 'desc');

        if ($paginate) {
            $limit = isset($data['limit']) ? $data['limit'] : 10;
            return $query->paginate($limit);
        }

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function listNotUsers(UserGroup $userGroup, $data, $paginate = false) {
        $query = User::buildQuery($data)
            ->whereNotIn('id', $userGroup->users->pluck('id')->toArray())
            ->orderBy('id', 'desc');

        if ($paginate) {
            $limit = isset($data['limit']) ? $data['limit'] : 10;
            return $query->paginate($limit);
        }

        return $query->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return UserGroup::with(['users', 'permissions'])->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByIdsWhereActive(array $ids) {
        return UserGroup::where('status', UserGroup::STATUS_ACTIVE)
            ->whereIn('id', $ids)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create($data) {
        $data['deleted_at'] = null;
        $data['created_by'] = auth()->id();
        $userGroup = UserGroup::withTrashed()->updateOrCreate(
            ['code' => $data['code']],
            $data
        );

        // if user is admin, dont save permissions, cause it's gonna be full access
        // save permissions if not admin
        if ($data['is_admin'] == false && !empty($data['permissions'])) 
            $userGroup->givePermissions($data['permissions']);
        
        if (!empty($data['userIds']))
            $userGroup->users()->sync($data['userIds']);
        
        return UserGroup::with('permissions')->where('id', $userGroup->id)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function update(UserGroup $userGroup, $data) {
        $data['updated_by'] = auth()->id();

        if (!empty($data['code']))
            unset($data['code']);
        
        // if user is admin delete all stored permissions, cause it's going to be full access
        if (isset($data['is_admin']) && $data['is_admin'] == true) {
            $userGroup->permissions()->delete();
        } else {
            if (isset($data['permissions']) && !empty($data['permissions']))
                $userGroup->givePermissions($data['permissions']);
        }

        $userGroup->fill($data);
        $userGroup->save();
        return $userGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function addUsers(UserGroup $userGroup, $user_ids) {
        $attachedIds = $userGroup->users()
            ->whereIn('id', $user_ids)
            ->pluck('id')
            ->toArray();
        $newIds = array_diff($user_ids, $attachedIds);
        $userGroup->users()->attach($newIds);
    }

    /**
     * {@inheritdoc}
     */
    public function removeUser(UserGroup $userGroup, User $user) {
        $userGroup->users()->detach($user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(UserGroup $userGroup, $forceDelete = false) {
        if ($forceDelete) {
            $userGroup->forceDelete();
        } else {
            $data['updated_by'] = auth()->id();
            $data['deleted_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $userGroup->fill($data);
            $userGroup->save();
        }
    }
}