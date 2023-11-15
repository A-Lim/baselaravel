<?php
namespace App\Repositories\Device;

use App\Models\User;
use App\Models\UserGroup;

interface IDeviceRepository {

    public function createOrUpdate(User $user, $data);

    public function delete(User $user, $uuid);

    public function getTokensForUserGroup(UserGroup $userGroup);

    public function allUserIds();
}