<?php

namespace Modules\Core\Packages\SMS;

class SmsBox implements SmsGetWay
{
    public function __construct()
    {
        $this->username = config("services.sms.sms_box.username");
        $this->password = config("services.sms.sms_box.password");
        $this->customerId = config("services.sms.sms_box.customerId");
        $this->senderText = config("services.sms.sms_box.senderText");
        $this->defdate = config("services.sms.sms_box.defdate");
        $this->isBlink = config("services.sms.sms_box.isBlink");
        $this->isFlash = config("services.sms.sms_box.isFlash");
    }

    public function send($message, $phone)
    {
        try {
            $data = [
                "username" => $this->username,
                "senderText" => $this->senderText,
                "password" => $this->password,
                "customerId" => $this->customerId,
                "defdate" => $this->defdate,
                "isBlink" => $this->isBlink,
                "isFlash" => $this->isFlash,
                "messageBody" => __('authentication::api.register.messages.code_send', ["code" => $message]),
                "recipientNumbers" => $phone //"96594971095",
            ];
            return $this->request($data);
        } catch (\Exception $e) {
            return ["Result" => "false"];
        }
    }

    public function request($data)
    {
        $ch = curl_init();
        $query = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.smsbox.com/SMSGateway/Services/Messaging.asmx/Http_SendSMS?$query");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        return $this->parse($result);
    }

    public function parse($result)
    {
        $result = str_replace(array("\n", "\r", "\t"), '', $result);
        $result = trim(str_replace('"', "'", $result));
        $simpleXml = simplexml_load_string($result);
        $json = json_encode($simpleXml);
        return json_decode($json, true);
    }
}
