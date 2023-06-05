<?php
namespace App\Http\Controllers\API\v1\Device;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Device\UpdateRequest;
use App\Repositories\Device\IDeviceRepository;

class DeviceController extends ApiController {

    private $deviceRepository;

    public function __construct(IDeviceRepository $iDeviceRepository) {
        $this->middleware('auth:api');
        $this->deviceRepository = $iDeviceRepository;
    }

    public function update(UpdateRequest $request) {
        $user = auth()->user();
        $this->deviceRepository->createOrUpdate($user, $request->all());
        $this->fcmSubscriptionToTopic($request->token, 'all');
        return $this->responseWithMessage(200, 'Token updated.');
    }

    private function fcmSubscriptionToTopic($token, $topic) {
        $url = 'https://iid.googleapis.com/iid/v1:batchAdd';

        $headers = [
            'Authorization: key='.config('app.fcm_server_key'),
            'Content-Type: application/json'
        ];

        $params = [
            'to' => '/topics/'.$topic,
            'registration_tokens' => [$token]
        ];

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
    }
}
