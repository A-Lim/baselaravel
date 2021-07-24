<?php

namespace App\Notifications\UserGroup;

use Illuminate\Notifications\Notification;

use App\Channels\FCMDataChannel;
use App\Models\UserGroup;

class SyncPermissions extends Notification {
    
    public function via($notifiable) {
        return [FCMDataChannel::class];
    }

    public function toDataFCM($notifiable) {
        $userGroup = $notifiable;
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
            'type' => 'userGroup',
            'userGroup' => $userGroup,
            'payload' => $notification_data
        ];
    }
}
