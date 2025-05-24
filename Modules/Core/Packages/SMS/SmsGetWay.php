<?php

namespace Modules\Core\Packages\SMS;

interface SmsGetWay
{
    public function send($message, $phone);
}


