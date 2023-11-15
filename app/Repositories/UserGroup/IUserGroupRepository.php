<?php
namespace App\Repositories\UserGroup;

use App\Models\User;
use App\Models\UserGroup;

interface IUserGroupRepository
{
    public function codeExists($code, $userGroupId = null);

    public function list($query, $paginate = false);

    public function listUsers(UserGroup $userGroup, $data, $paginate = false);

    public function listNotUsers(UserGroup $userGroup, $data, $paginate = false);

    public function find($id);

    public function findByIdsWhereActive(array $ids);

    public function create($data);

    public function update(UserGroup $userGroup, $data);

    public function addUsers(UserGroup $userGroup, $user_ids);

    public function removeUser(UserGroup $userGroup, User $user);

    public function delete(UserGroup $userGroup, $forceDelete = false);
}