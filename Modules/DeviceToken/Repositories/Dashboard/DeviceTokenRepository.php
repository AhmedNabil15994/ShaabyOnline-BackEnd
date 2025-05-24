<?php

namespace Modules\DeviceToken\Repositories\Dashboard;

use Modules\DeviceToken\Entities\DeviceToken;
use Hash;
use DB;

class DeviceTokenRepository
{
    function __construct(DeviceToken $token)
    {
        $this->token   = $token;
    }

    public function getAll($platform,$order = 'id', $sort = 'desc')
    {
        $tokens = $this->token->where('platform',$platform)->orderBy($order, $sort)->get();
        return $tokens;
    }
}
