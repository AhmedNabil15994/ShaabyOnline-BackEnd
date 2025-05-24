<?php

namespace Modules\Vendor\ViewComposers\Dashboard;

use Modules\Vendor\Repositories\Dashboard\VendorStatusRepository as VendorStatus;
use Illuminate\View\View;
use Cache;

class VendorStatusComposer
{
    public $vendorStatuses = [];

    public function __construct(VendorStatus $vendorStatus)
    {
        $this->vendorStatuses =  $vendorStatus->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('vendorStatuses' , $this->vendorStatuses);
    }
}
