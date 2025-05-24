<?php

namespace Modules\Transaction\Services;

class UPaymentService
{
    /*
     * Live CREDENTIALS
    const MERCHANT_ID = "679";
    const USERNAME = "tocaan";
    const PASSWORD = "ml4nf9wx2utuogcr";
    const API_KEY = "nLuf1cAgcx2KFEViDSzxN785vXqlNx4FawQaQ086";
    */

    /*
     * Test CREDENTIALS
     */
    const MERCHANT_ID = "1201";
    const USERNAME = "test";
    const PASSWORD = "test";
    const API_KEY = "jtest123";

    protected $paymentMode = 'test_mode';
    protected $test_mode = 1;
    protected $whitelabled = true;
    protected $paymentUrl = "https://api.upayments.com/test-payment";
    protected $apiKey = '';

    public function __construct()
    {
        if (config('setting.supported_payments.upayment.payment_mode') == 'live_mode') {
            $this->paymentMode = 'live_mode';
            $this->test_mode = 0;
            $this->whitelabled = false;
            $this->paymentUrl = "https://api.upayments.com/payment-request";
            $this->apiKey = password_hash(config('setting.supported_payments.upayment.' . $this->paymentMode . '.api_key') ?? self::API_KEY, PASSWORD_BCRYPT);
        } else {
            $this->apiKey = config('setting.supported_payments.upayment.' . $this->paymentMode . '.api_key') ?? self::API_KEY;
        }
    }

    public function send($order, $payment, $orderType = 'frontend-order', $extraData = [])
    {
        if (auth()->check()) {
            $user = [
                'name' => auth()->user()->name ?? '',
                'email' => auth()->user()->email ?? '',
                'mobile' => auth()->user()->calling_code ?? '' . auth()->user()->mobile ?? '',
            ];
        } else {
            $user = [
                'name' => 'Guest User',
                'email' => 'guest_user@example.com',
                'mobile' => '00000000',
            ];
        }

        $extraMerchantsData = array();
        $extraMerchantsData['amounts'][0] = $order['total'];
        if (config('setting.supported_payments.upayment.account_type') == 'vendor_account') {
            $IBAN = $extraData['ibans'];
            $extraMerchantsData['charges'][0] = $extraData['knetEquation'] ?? 0;
            $extraMerchantsData['chargeType'][0] = 'fixed';
            $extraMerchantsData['cc_charges'][0] = $extraData['ccEquation'] ?? 0;
            $extraMerchantsData['cc_chargeType'][0] = 'fixed';
        } else {
            $IBAN = config('setting.supported_payments.upayment.' . $this->paymentMode . '.iban') ?? '';
            $extraMerchantsData['charges'][0] = config('setting.supported_payments.upayment.client_commissions.knet.commission') ?? 0; // knet commission
            $extraMerchantsData['chargeType'][0] = config('setting.supported_payments.upayment.client_commissions.knet.commission_type') ?? 'fixed'; // or 'percentage'
            $extraMerchantsData['cc_charges'][0] = config('setting.supported_payments.upayment.client_commissions.cc.commission') ?? 0; // or 'percentage'
            $extraMerchantsData['cc_chargeType'][0] = config('setting.supported_payments.upayment.client_commissions.cc.commission_type') ?? 'fixed'; // or 'percentage'
        }
        $extraMerchantsData['ibans'][0] = $IBAN;

        /* $extraMerchantsData = array();
        $extraMerchantsData['amounts'][0] = $order['total'];
        $extraMerchantsData['charges'][0] = 0.350;
        $extraMerchantsData['chargeType'][0] = 'fixed'; // or 'percentage'
        $extraMerchantsData['cc_charges'][0] = 2.7; // or 'percentage'
        $extraMerchantsData['cc_chargeType'][0] = 'percentage'; // or 'percentage'
        $extraMerchantsData['ibans'][0] = config('setting.supported_payments.upayment.' . $this->paymentMode . '.iban') ?? ''; */

        $url = $this->paymentUrls($orderType);

        $fields = [
            'api_key' => $this->apiKey,
            'merchant_id' => config('setting.supported_payments.upayment.' . $this->paymentMode . '.merchant_id') ?? self::MERCHANT_ID,
            'username' => config('setting.supported_payments.upayment.' . $this->paymentMode . '.username') ?? self::USERNAME,
            'password' => stripslashes(config('setting.supported_payments.upayment.' . $this->paymentMode . '.password') ?? self::PASSWORD),
            'order_id' => $order['id'],
            'CurrencyCode' => 'KWD', //only works in production mode
            'CstFName' => $user['name'],
            'CstEmail' => $user['email'],
            'CstMobile' => $user['mobile'],
            'success_url' => $url['success'],
            'error_url' => $url['failed'],
//            'ExtraMerchantsData' => json_encode($extraMerchantsData),
            'test_mode' => $this->test_mode, // 1 == test mode enabled
            'whitelabled' => $this->whitelabled, // false == in live mode
            'payment_gateway' => $payment, // knet / cc
            'reference' => $order['id'],
            'notifyURL' => $url['webhooks'],
            'total_price' => $order['total'],
        ];

        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paymentUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $server_output = json_decode($server_output, true);
        /* logger('UPayment-Response::');
        logger($server_output); */
        return $server_output['paymentURL'] ?? null;
    }

    public function paymentUrls($orderType)
    {
        if ($orderType == 'api-order') {
            $url['success'] = url(route('api.orders.success'));
            $url['failed'] = url(route('api.orders.failed'));
            $url['webhooks'] = url(route('api.orders.webhooks'));
        } else {
            $url['success'] = url(route('frontend.orders.success'));
            $url['failed'] = url(route('frontend.orders.failed'));
            $url['webhooks'] = url(route('frontend.orders.webhooks'));
        }
        return $url;
    }
}
