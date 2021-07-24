<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Repositories\User\IUserRepository;
use App\Repositories\Device\IDeviceRepository;
use App\Repositories\Notification\INotificationRepository;

use App\Models\Announcement;

class CustomFCMChannel {
    private $userRepository;
    private $deviceRepository;
    private $notificationRepository;

    public function __construct(IUserRepository $iUserRepository,
        IDeviceRepository $iDeviceRepository,
        INotificationRepository $iNotificationRepository) {
        $this->userRepository = $iUserRepository;
        $this->deviceRepository = $iDeviceRepository;
        $this->notificationRepository = $iNotificationRepository;
    }

    public function send($notifiable, Notification $notification) {
        $data = $notification->toCustomFCM($notifiable);
        
        if (isset($data['topic']))
            $this->sendToTopic($data['payload'], $data['topic']);

        if (isset($data['users']))
            $this->sendToUsers($data['payload'], $data['users']);
    }

    private function sendToTopic($data, $topic) {
        $notificationLog = $this->sendNotification($data, null, $topic);
        $user_ids = null;

        switch($topic) {
            case Announcement::AUDIENCE_ALL:
                // TODO:: optimized
                // join table instead of retrieving perhaps ??
                $user_ids = $this->deviceRepository
                    ->allUserIds()
                    ->toArray();
                break;
        }

        $this->notificationRepository->create($user_ids, $notificationLog->id, $data);
    }

    private function sendToUsers($data, $users) {
        // TODO:: optimized
        $device_ids = $users
            ->where('device_token', '<>', null)
            ->pluck('device_token')
            ->toArray();
            
        $notificationLog = $this->sendNotification($data, $device_ids);
        $this->notificationRepository->create($users, $notificationLog->id, $data);
    }

    private function sendNotification($data, $registration_ids = null, $topic = null) {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = [
            'Authorization: key='.config('app.fcm_server_key'),
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $params = [
            'notification' => $data,
            // 'data' => $data,
            'priority' => 'high'
        ];

        if ($registration_ids)
            $params['registration_ids'] = $registration_ids;

        if ($topic)
            $params['to'] = '/topics/'.$topic;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // log notification requests
        $notificationLog = $this->notificationRepository->log([
            'request_data' => json_encode($params),
            'response_data' => $result,
            'status' => $status
        ]);

        return $notificationLog;
    }
}