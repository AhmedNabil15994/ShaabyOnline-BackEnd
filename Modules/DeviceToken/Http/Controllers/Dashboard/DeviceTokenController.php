<?php

namespace Modules\DeviceToken\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DeviceToken\Repositories\Dashboard\DeviceTokenRepository;
use Modules\DeviceToken\Traits\FCMTrait;

class DeviceTokenController extends Controller
{
    use FCMTrait;

    function __construct(DeviceTokenRepository $token)
    {
        $this->token = $token;
    }

    public function index()
    {
        return view('devicetoken::dashboard.index');
    }

    public function send(Request $request)
    {
        $devices['ios']     =  $this->token->getAll('IOS');
        $devices['android'] =  $this->token->getAll('ANDROID');

        $send = $this->sendNotification($devices,$request);

        return Response()->json([true , __('apps::dashboard.general.message_create_success')]);
    }
}
