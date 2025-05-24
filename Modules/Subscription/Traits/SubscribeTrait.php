<?php

namespace Modules\Subscription\Traits;

trait SubscribeTrait
{
    public function subscriptionDetails($package,$vendorSubscribed)
    {
        if (!is_null($vendorSubscribed))
            return $this->renewSubscribe($package,$vendorSubscribed);

        return $this->newSubscribe($package,$vendorSubscribed);
    }

    public function renewSubscribe($package,$vendorSubscribed = null)
    {
        $details = [];

        $details['total']              = $package->special_price ? $package->special_price : $package->price;
        $details['original_price']     = $package->price;
        $details['start_at'] 	         = $this->startAt();
        $details['end_at'] 		         = $this->endAt($package->months,$vendorSubscribed->end_at);

        return $details;
    }

    public function newSubscribe($package)
    {
        $details = [];

        $details['total']              = $package->special_price ? $package->special_price : $package->price;
        $details['original_price']     = $package->price;
        $details['start_at'] 	         = $this->startAt();
        $details['end_at'] 		         = $this->endAt($package->months);

        return $details;
    }

    public function startAt()
    {
        return date('Y-m-d');
    }


    public function endAt($months,$endOfSubscribed = null)
    {
        if (!is_null($endOfSubscribed))
          return date('Y-m-d', strtotime("+".$months." months", strtotime($endOfSubscribed)));

        return date('Y-m-d', strtotime('+'.$months.' months'));
    }
}
