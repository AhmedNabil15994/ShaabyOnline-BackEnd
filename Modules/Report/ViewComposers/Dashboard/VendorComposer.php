<?php

namespace Modules\Report\ViewComposers\Dashboard;

use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Illuminate\View\View;
use Cache;

class VendorComposer
{
    public function __construct(Vendor $vendor)
    {
        $this->vendorSubscribed =  $vendor->countSubscriptionsVendors();
        $this->countVendors     =  $vendor->countVendors();
    }

    public function compose(View $view)
    {
        $view->with('vendorSubscribed', $this->vendorSubscribed);
        $view->with('countVendors'    , $this->countVendors);
    }
}
