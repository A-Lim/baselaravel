<?php

namespace App\Notifications\UserGroup;

use Illuminate\Notifications\Notification;

use App\Channels\FCMDataChannel;
use Exception;

class SyncPermissions extends Notification {

    public function via($notifiable) {
        return [FCMDataChannel::class];
    }

    public function toDataFCM($notifiable) {
        $class = get_class($notifiable);
        $type = null;

        switch ($class) {
            case \App\Models\User::class:
                $type = 'user';
                break;

            case \App\Models\UserGroup::class:
                $type = 'usergroup';
                break;

            default:
                throw new Exception('Invalid class type.');
        }

        $data = $notifiable;
        $notification_data = [
            'data_notification' => true, // flag to update frontend if it's message or data notification
            'type' => 'permissions',
            'action' => 'sync'
        ];

        // array format
        // - topic: "all" or any topic that is registered in fcm
        // - type: type of data
        // - "string": "data"
        // eg:
        // [
        //     'type' => 'users'
        //     'users' => $users (array key must match the value of 'type')
        // ]
        return [
            'type' => $type,
            $type => $data,
            'payload' => $notification_data
        ];
    }
}
