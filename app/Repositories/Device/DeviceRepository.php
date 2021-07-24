<?php
namespace App\Repositories\Device;

use App\Models\User;
use App\Models\Device;
use App\Models\UserGroup;

class DeviceRepository implements IDeviceRepository {

    /**
     * {@inheritdoc}
     */
    public function createOrUpdate(User $user, $data) {
        $data['user_id'] = $user->id;

        $tokenExists = Device::where('token', $data['token']);
        if ($tokenExists) {
            return Device::updateOrCreate(
                ['token' => $data['token']],
                $data
            );
        }

        return Device::updateOrCreate(
            ['uuid' => $data['uuid']],
            $data
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(User $user, $uuid) {
        Device::where('uuid', $uuid)->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function getTokensForUserGroup(UserGroup $userGroup) {
        return Device::join('users', 'users.id', '=', 'devices.user_id')
            ->join('user_usergroup', 'user_usergroup.user_id', '=', 'devices.user_id')
            ->where('user_usergroup.usergroup_id', $userGroup->id)
            ->select('devices.token')
            ->pluck('token')
            ->toArray();
    }


    /**
     * {@inheritdoc}
     */
    public function allUserIds() {
        return Device::select('user_id')
            ->distinct('user_id')
            ->get()
            ->pluck('user_id');
    }
}