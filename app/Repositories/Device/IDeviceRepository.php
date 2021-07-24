<?php
namespace App\Repositories\Device;

use App\Models\User;
use App\Models\Device;
use App\Models\UserGroup;

interface IDeviceRepository {
    /**
     * Create or update a device for user
     * @param User $user 
     * @param array $data
     * @return Device
     */
    public function createOrUpdate(User $user, $data);

    /**
     * Delete a device by user and uuid
     * @param User $user 
     * @param string $uuid
     * @return void
     */
    public function delete(User $user, $uuid);

    /**
     * Retrieve tokens from usergroup
     * @param UserGroup $userGroup
     * @return array $tokens
     */
    public function getTokensForUserGroup(UserGroup $userGroup);

    /**
     * Get all user_id of devices
     * @return array int
     */
    public function allUserIds();
}