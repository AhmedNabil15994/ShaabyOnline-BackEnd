<?php

namespace Modules\Vendor\Repositories\Vendor;

use Modules\Vendor\Entities\Vendor;
use Hash;
use DB;

class VendorRepository
{

    function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $vendors = $this->vendor->with(['subscribed', 'subbscription'])->whereHas('sellers', function ($q) {
            $q->where('seller_id', auth()->user()->id);
        })->orderBy($order, $sort)->get();
        return $vendors;
    }

    public function findById($id)
    {
        $vendor = $this->vendor->whereHas('sellers', function ($q) {
            $q->where('seller_id', auth()->user()->id);
        })->withDeleted()->find($id);
        return $vendor;
    }
}
