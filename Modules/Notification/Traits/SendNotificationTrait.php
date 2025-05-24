<?php

namespace Modules\Notification\Traits;

use Modules\User\Entities\UserFireBaseToken;

trait SendNotificationTrait
{
    public function send($data, $tokens = null, $googleAPIKeyType = 'main_app')
    {
        if (is_array($tokens)) {
            $tokens = array_values(array_unique($tokens));
        } else {
            $tokens = array($tokens);
        }

        $ios = UserFireBaseToken::
            whereIn('firebase_token', $tokens)
            ->select('firebase_token')
            ->where('device_type', '2')
            ->groupBy('firebase_token')
            ->pluck('firebase_token');

        $android = UserFireBaseToken::
            whereIn('firebase_token', $tokens)
            ->where('device_type', '1')
            ->groupBy('firebase_token')
            ->pluck('firebase_token');

        if ($ios) {
            $regIdIOS = array_chunk(json_decode($ios), 999);

            foreach ($regIdIOS as $tokens) {
                $msg[] = $this->PushIOS($data, $tokens, $googleAPIKeyType);
            }
        }

        if ($android) {
            $regIdAndroid = array_chunk(json_decode($android), 999);

            foreach ($regIdAndroid as $tokens) {
                $this->PushANDROID($data, $tokens, $googleAPIKeyType);
            }
        }
    }

    public function PushIOS($data, $tokens, $googleAPIKeyType = 'main_app')
    {
        $notification = [
            'title' => $data['title'],
            'body' => $data['body'],
            "domain" => get_current_main_domain(),
            'sound' => 'default',
            'priority' => 'high',
            'badge' => '0',
        ];

        $data = [
            "type" => $data['type'],
            "id" => $data['id'],
            "domain" => get_current_main_domain(),
        ];

        $fields_ios = [
            'registration_ids' => $tokens,
            'notification' => $notification,
            'data' => $data,
        ];

        return $this->Push($fields_ios, $googleAPIKeyType);
    }

    public function PushANDROID($data, $tokens, $googleAPIKeyType = 'main_app')
    {
        $fcmObject = [
            'registration_ids' => $tokens,
            'priority' => 'high',
            'notification' => [
                'title' => $data['title'],
                'body' => $data['body'],
                "domain" => get_current_main_domain(),
                "icon" => "launcher_icon",
            ],
            'data' => [
                "id" => $data['id'] ?? null,
                "type" => $data['type'] ?? '',
                "domain" => get_current_main_domain(),
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            ],
        ];
        return $this->Push($fcmObject, $googleAPIKeyType);
    }

    /* public function PushANDROID($data, $tokens)
    {
    $notification = [
    'title' => $data['title'],
    'body' => $data['body'],
    'sound' => 'default',
    'priority' => 'high',
    "type" => $data['type'],
    "id" => $data['id'],
    ];

    $fields_android = [
    'registration_ids' => $tokens,
    'data' => $notification
    ];

    return $this->Push($fields_android);
    } */

    public function Push($fields, $googleAPIKeyType = 'main_app')
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $server_key = $googleAPIKeyType == 'driver_app' ? config('firebase.driverGoogleAPIKey') : config('firebase.googleAPIKey');

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        logger('FCM::result::');
        logger($result);
        return $result;
    }
}
