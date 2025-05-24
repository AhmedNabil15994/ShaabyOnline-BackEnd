<?php

namespace Modules\DeviceToken\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\DeviceToken\Repositories\WebService\DeviceTokenRepository;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class DeviceTokenController extends WebServiceController
{

    function __construct(DeviceTokenRepository $token)
    {
        $this->token = $token;
    }

    public function create(Request $request)
    {
        $token =  $this->token->create($request);

        return $this->response([]);
    }
}
