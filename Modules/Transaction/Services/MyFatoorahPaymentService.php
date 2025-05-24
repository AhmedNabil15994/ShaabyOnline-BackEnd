<?php

namespace Modules\Transaction\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Modules\Transaction\Services\PaymentInterface;

class MyFatoorahPaymentService implements PaymentInterface
{
    public $API_KEY = "";

    public $URL = "https://apitest.myfatoorah.com/v2/";

    public function __construct()
    {
        $this->API_KEY = config('setting.supported_payments.myfatourah.test_mode.api_key');
        if (config('setting.supported_payments.myfatourah.payment_mode') == "live_mode") {
            $this->API_KEY = config('setting.supported_payments.myfatourah.live_mode.api_key');
            $this->URL  = "https://api.myfatoorah.com/v2/";
        }
    }

    public function send($order, $payment = "knet", $type = "api-order")
    {
        $fields = $this->getRequestFields($order, $type);
        $client = new Client();

        try {
            $res = $client->post($this->URL . "SendPayment", [

                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $this->API_KEY
                ],

                RequestOptions::JSON => $fields
            ]);
            $body = json_decode($res->getBody(), true);

            if ($body["IsSuccess"] && isset($body["Data"]["InvoiceURL"])) {
                return $body["Data"]["InvoiceURL"];
            }

            throw new \Exception("error payment");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 503);
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function getTransactionDetails($id)
    {
        $client = new Client();

        try {
            $res = $client->post($this->URL . "GetPaymentStatus", [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $this->API_KEY
                ],
                RequestOptions::JSON => [
                    "KeyType" => "PaymentId",
                    "Key"    => $id
                ]
            ]);

            $body =  json_decode($res->getBody(), true);

            if ($body["IsSuccess"] && isset($body["Data"])) {
                return $body["Data"];
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 503);
        }
    }

    /**
     * @param $order_id
     * @param $order
     * @return array
     */
    private function getRequestFields($order, $type)
    {
        $url = $this->paymentUrls($type);
        return [
            'InvoiceValue' => $order["total"],
            'DisplayCurrencyIso' => "KWD",
            'NotificationOption' => "LNK",
            'Language' => locale(),
            "CustomerName" => optional($order->user)->name ?? "Unknown",
            "CustomerEmail" => optional($order->user)->email ?? 'test@example.com',
            "CustomerMobile" => optional($order->user)->mobile ?? "00000000",
            "MobileCountryCode" => optional($order->user)->calling_code ?? "+965",

            'CallBackUrl' => $url["success"] ?? '',
            "ErrorUrl" => $url["failed"] ?? '',
            "UserDefinedField" => $order["id"],
        ];
    }

    public function paymentUrls($type)
    {
        if ($type == 'api-order') {
            $url['success'] = url(route('api.myfatoorah.orders.success'));
            $url['failed']  = url(route('api.myfatoorah.orders.failed'));
        } elseif ($type == 'frontend-order') {
            $url['success'] = url(route('frontend.myfatoorah.orders.success'));
            $url['failed']  = url(route('frontend.myfatoorah.orders.failed'));
        } else {
            $url['success'] = null;
            $url['failed']  = null;
        }
        return $url;
    }

    public function getResultForPayment($order, $type = "api-order", $payment = "knet")
    {
        $orderInfo["id"] = $order["id"] ?? null;
        $orderInfo["total"] = $order["total"] ?? null;
        $orderInfo["name"] = optional($order->user)->name ?? "Unknown";
        $orderInfo["email"] = optional($order->user)->email ?? 'test@example.com';
        $orderInfo["mobile"] = optional($order->user)->mobile ?? "00000000";
        $orderInfo["calling_code"] = optional($order->user)->calling_code ?? '965';
        return $this->send($orderInfo, $type, $payment);
    }
}
