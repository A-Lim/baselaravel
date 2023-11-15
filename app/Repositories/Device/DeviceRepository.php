<?php
namespace App\Repositories\Device;

use App\Models\User;
use App\Models\Device;
use App\Models\UserGroup;

class DeviceRepository implements IDeviceRepository {

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

    public function delete(User $user, $uuid) {
        Device::where('uuid', $uuid)->delete();
    }

    public function getTokensForUser(User $user) {
        return Device::where('user_id', $user->id)
            ->select('token')
            ->pluck('token')
            ->toArray();
    }

    public function getTokensForUserGroup(UserGroup $userGroup) {
        return Device::join('users', 'users.id', '=', 'devices.user_id')
            ->join('user_usergroup', 'user_usergroup.user_id', '=', 'devices.user_id')
            ->where('user_usergroup.usergroup_id', $userGroup->id)
            ->select('devices.token')
            ->pluck('token')
            ->toArray();
    }

    public function allUserIds() {
        return Device::select('user_id')
            ->distinct('user_id')
            ->get()
            ->pluck('user_id');
    }
}