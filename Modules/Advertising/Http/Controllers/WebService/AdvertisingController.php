<?php

namespace Modules\Advertising\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Advertising\Transformers\WebService\AdvertisingResource;
use Modules\Advertising\Repositories\WebService\AdvertisingRepository as Advertising;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class AdvertisingController extends WebServiceController
{
    protected $advertising;

    function __construct(Advertising $advertising)
    {
        $this->advertising = $advertising;
    }

    public function advertising()
    {
        $advertising = $this->advertising->getRandomPerRequest();
        return $this->response(AdvertisingResource::collection($advertising));
    }

}
