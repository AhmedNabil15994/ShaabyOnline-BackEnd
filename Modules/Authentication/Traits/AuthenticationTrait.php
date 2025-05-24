<?php

namespace Modules\Authentication\Traits;

use Illuminate\Support\Facades\DB;

trait AuthenticationTrait
{
    public function sendVerificationCode($requestData, $user = null)
    {
        $code = mt_rand(000000, 999999);
        $mobile = $requestData->calling_code ?? '965' . $requestData->mobile;

        $message = __('authentication::frontend.verification_code.messages.your_verification_code_is') . ' ' . $code;
        $params = [
            'username' => 'conckw',
            'password' => '56551040',
            'customerid' => '2924',
            'sendertext' => 'SMSBOX.COM',
            'messagebody' => $message,
            'recipientnumbers' => $mobile,
            'defdate' => '',
            'isblink' => false,
            'isflash' => false,
        ];
        $url = "https://www.smsbox.com/smsgateway/services/messaging.asmx/Http_SendSMS?" . http_build_query($params);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if (!$err) {
            // save user verification code.
            $saveCodeCheck = $this->AddUserMobileCode($user, $code);
            // redirect to verification code page
            if ($httpCode == 200 && $saveCodeCheck == true) {
                // $requestParams['full_mobile'] = $mobile;
                $requestParams['mobile'] = $requestData->mobile;
                if (isset($requestData->type) && !is_null($requestData->type)) {
                    $requestParams['type'] = $requestData->type;
                }
                return $requestParams;
            }
        }
        return false;
    }

    public function AddUserMobileCode($user, $code)
    {
        DB::beginTransaction();

        try {
            $user->mobileCodes()->create([
                'code' => $code,
            ]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
