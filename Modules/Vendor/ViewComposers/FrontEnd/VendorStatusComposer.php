<?php

namespace Modules\Vendor\ViewComposers\FrontEnd;

use Modules\Vendor\Repositories\FrontEnd\VendorStatusRepository as VendorStatus;
use Illuminate\View\View;
use Cache;

class VendorStatusComposer
{
    public $vendorStatuses = [];

    public function __construct(VendorStatus $status)
    {
        $this->vendorStatuses =  $status->getAll();
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
