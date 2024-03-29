<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Repositories\User\IUserRepository;
use App\Repositories\Device\IDeviceRepository;
use App\Repositories\Notification\INotificationRepository;

/**
 * Sends notification without alert
 */
class FCMDataChannel {
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
        $data = $notification->toDataFCM($notifiable);
        $model = $data[$data['type']];
        $device_ids = [];

        if (isset($data['topic'])) {
            $this->sendNotification($data['payload'], null, $data['topic']);
            return;
        }

        switch ($data['type']) {
            case 'user':
                $device_ids = $this->deviceRepository->getTokensForUser($model);
                break;

            case 'usergroup':
                $device_ids = $this->deviceRepository->getTokensForUserGroup($model);
                break;
        }
        
        if (!empty($device_ids))
            $this->sendNotification($data['payload'], $device_ids);
    }

    private function sendNotification($data, $registration_ids = null, $topic = null) {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = [
            'Authorization: key='.config('app.fcm_server_key'),
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $params = [
            'data' => $data,
            'priority' => 'high',
            // 'content_available' => true
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
    }
}