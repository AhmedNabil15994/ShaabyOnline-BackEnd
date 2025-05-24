<?php

namespace Modules\Subscription\Repositories\FrontEnd;

use Modules\Subscription\Entities\Package;
use Hash;
use DB;

class PackageRepository
{

    function __construct(Package $package)
    {
        $this->package   = $package;
    }

}
