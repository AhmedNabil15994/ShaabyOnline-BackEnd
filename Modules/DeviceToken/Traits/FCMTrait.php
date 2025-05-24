<?php

namespace Modules\DeviceToken\Traits;

trait FCMTrait
{
		public function getPlatformDevice($user)
		{
				$token = $user->deviceToken;

				if ($token) {

					$tokens['ios'] 		= $token->where('platform','IOS');

					$tokens['android'] = $token->where('platform','ANDROID');

				}

				return $tokens;
		}

		public function sendNotification($devices,$request)
		{
				foreach (config('translatable.locales') as $lang) {

					// FILTER IOS DEVICES
					if ($devices['ios']) {

								 $iosTokens = $devices['ios']->where('lang',$lang)->pluck('device_token')->toArray();

	 							 $chunkIOS = $this->uniqueTokens($iosTokens);

 	 							 $regIdIOS = array_chunk($chunkIOS,999);

			 					 foreach ($regIdIOS as $iTokens) {
									   $this->PushIOS($request,$iTokens,$lang);
			 					 }
					}

					// FILTER ANDROID DEVICES
					if ($devices['android']) {

							$androidTokens = $devices['android']->where('lang',$lang)->pluck('device_token')->toArray();

							$tokensAndroid = $this->uniqueTokens($androidTokens);

							$regIdAndroid = array_chunk($tokensAndroid,999);

							foreach ($regIdAndroid as $aTokens) {
									$this->PushANDROID($request,$aTokens,$lang);
							}

					}

				}

				return true;
		}

		public function uniqueTokens($tokens)
		{
				if (is_array($tokens)) {
						$tokens = array_values(array_unique($tokens));
				} else {
						$tokens = array($tokens);
				}

				return $tokens;
		}

    public function PushIOS($data,$tokens,$lang)
    {
        $notification = [
          'title'    => $data['title'][$lang],
          'body'     => $data['description'][$lang],
          'sound'    => 'default',
          'priority' => 'high',
          'badge' 	 => '0',
        ];

        $data = [
					"type"     => $data['type'] ? $data['type'] : 'general',
          "id"       => $data['id'],
        ];

        $fields_ios = [
            'registration_ids' => $tokens,
            'notification'     => $notification,
            'data'             => $data,
        ];

        return $this->Push($fields_ios);
    }

    public function PushANDROID($data,$tokens,$lang)
    {
        $notification = [
          'title'    => $data['title'][$lang],
          'body'     => $data['body'][$lang],
          'sound'    => 'default',
          'priority' => 'high',
          "type"     => $data['type'] ? $data['type'] : 'general',
          "id"       => $data['id'],
        ];

        $fields_android = [
            'registration_ids' => $tokens,
            'data'             => $notification
        ];

        return $this->Push($fields_android);
    }

    public function Push($fields)
    {
        	$url = 'https://fcm.googleapis.com/fcm/send';

        	$server_key = 'AAAA9itBKr8:APA91bHxK4TNPntHRLpE3hLjiGmn9LBrU2B7LbGGTGUKuomQ_SdLwTWMo88aGJLOcaLri4UbOrkGfjmpWwCfK2gRRmsMtdlt17hKVFabECBto3WPc69lUVQcnsp8MWj0WEN1hnDVsgnK';

        	$headers = array(
        		'Content-Type:application/json',
        		'Authorization:key='.$server_key
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
        	if ($result === FALSE) {
        		die('FCM Send Error: ' . curl_error($ch));
        	}
        	curl_close($ch);
        	return $result;
    	}
}
