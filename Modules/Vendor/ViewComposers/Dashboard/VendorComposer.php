<?php

namespace Modules\Vendor\ViewComposers\Dashboard;

use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Illuminate\View\View;
use Cache;

class VendorComposer
{
    public $vendors = [];
    public $activeVendors = [];

    public function __construct(Vendor $vendor)
    {
        $this->vendors = $vendor->getAll();
        $this->activeVendors = $vendor->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['vendors' => $this->vendors, 'activeVendors' => $this->activeVendors]);
    }
}
