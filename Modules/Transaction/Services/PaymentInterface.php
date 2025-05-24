<?php

namespace Modules\Transaction\Services;

interface PaymentInterface
{
    public function send($order, $type = "api-order", $payment = "knet");

    public function getResultForPayment($order, $type = "api-order", $payment = "knet");
}
