<?php

namespace Modules\Vendor\ViewComposers\Vendor;

use Modules\Vendor\Repositories\Vendor\VendorRepository as Vendor;
use Illuminate\View\View;
use Cache;

class VendorComposer
{
    public $vendors = [];

    public function __construct(Vendor $vendor)
    {
        $this->vendors =  $vendor->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('vendors' , $this->vendors);
    }
}
