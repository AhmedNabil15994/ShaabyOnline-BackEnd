<?php

namespace Modules\DeviceToken\Repositories\WebService;

use Modules\DeviceToken\Entities\DeviceToken;
use DB;

class DeviceTokenRepository
{
    function __construct(DeviceToken $token)
    {
        $this->token   = $token;
    }

    public function getAll($platform)
    {
        $tokens = $this->token->where('platform',$platform)->get();
        return $tokens;
    }

    public function create($request)
    {
        DB::beginTransaction();

        $this->updateUserTokens($request);

        $lang  = locale();

        try {

            $token = $this->token->updateOrCreate([
                'device_token' => $request['device_token'],
            ],
            [
                'device_token' => $request['device_token'],
                'user_id'      => $request['user_id'],
                'platform'     => $request['platform'],
                'lang'         => locale(),
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function updateUserTokens($request)
    {
        $tokens = $this->token->where('user_id', '=', $request['user_id'])->get();

        if (count($tokens) > 0) {
            foreach ($tokens as $token) {
                $token->update([
                    'user_id' => null
                ]);
            }
        }

    }
}
