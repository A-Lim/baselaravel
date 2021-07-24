<?php
namespace App\Repositories\UserGroup;

use App\Models\User;
use App\Models\UserGroup;

interface IUserGroupRepository
{
    /**
     * Check if code exists
     */
    public function codeExists($code, $userGroupId = null);

     /**
     * List usergroup
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return [UserGroup]
     */
    public function list($query, $paginate = false);

    /**
     * List users that belong to usergroup
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return [User]
     */
    public function listUsers(UserGroup $userGroup, $data, $paginate = false);

    /**
     * List users that does not belong to usergroup
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return [User]
     */
    public function listNotUsers(UserGroup $userGroup, $data, $paginate = false);

    /**
     * Find usergroup from id
     * 
     * @param integer $id
     * @return UserGroup
     */
    public function find($id);


    /**
     * Find multiple by ids where active
     * 
     * @param integer $id
     * @return [UserGroup]
     */
    public function findByIdsWhereActive(array $ids);

    
    /**
     * Creates a usergroup
     * 
     * @param array $data
     * @return UserGroup
     */
    public function create($data);

    /**
     * Updates a usergroup
     * 
     * @param UserGroup $userGroup
     * @param array $data
     * @return UserGroup
     */
    public function update(UserGroup $userGroup, $data);

    /**
     * Adds users to a usergroup
     * 
     * @param UserGroup $userGroup
     * @param array $user_ids
     * @return void
     */
    public function addUsers(UserGroup $userGroup, $user_ids);

    /**
     * Removes a user from usergroup
     * 
     * @param UserGroup $userGroup
     * @param User $user
     * @return void
     */
    public function removeUser(UserGroup $userGroup, User $user);

    /**
     * Deletes a usergroup
     * 
     * @param UserGroup $userGroup
     * @param bool $forceDelete
     * @return void
     */
    public function delete(UserGroup $userGroup, $forceDelete = false);

}