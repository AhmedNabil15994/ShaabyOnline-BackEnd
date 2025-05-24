<?php

namespace Modules\Vendor\Repositories\FrontEnd;

use Modules\Vendor\Entities\VendorStatus;
use Hash;
use DB;

class VendorStatusRepository
{

    function __construct(VendorStatus $vendorStatus)
    {
        $this->vendorStatus   = $vendorStatus;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $vendor_status = $this->vendorStatus->orderBy($order, $sort)->get();
        return $vendor_status;
    }
}
