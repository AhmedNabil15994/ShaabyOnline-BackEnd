<?php

namespace Modules\Subscription\Repositories\FrontEnd;

use Modules\Subscription\Entities\SubscriptionHistory;
use Modules\Subscription\Traits\SubscribeTrait;
use Modules\Subscription\Entities\Subscription;
use DB;

class SubscriptionRepository
{
    use SubscribeTrait;

    function __construct(Subscription $subscription,SubscriptionHistory $history)
    {
        $this->history        = $history;
        $this->subscription   = $subscription;
    }


}
