<?php

namespace Modules\User\Http\Controllers\WebService;

use Modules\User\Http\Requests\WebService\UserFirebaseTokenRequest;
use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\User\Entities\UserFireBaseToken;

class UserFirebaseTokenController extends WebServiceController
{

    /**
     * store or update user firebase token
     * @param Request $request
     * @return mixed
     */
    public function store(UserFirebaseTokenRequest $request)
    {
        /*auth()->user()->firebase_tokens()->updateOrCreate(
        	['device_type' => $request->device_type],
        	['firebase_token' => $request->firebase_token, 'device_type' => $request->device_type]
        );*/

        UserFireBaseToken::updateOrCreate([
            'firebase_token' => $request->firebase_token,
        ], [
            'firebase_token' => $request->firebase_token,
            'user_id' => $request->user_id ?? null,
            'device_type' => $request->device_type,
        ]);

        return $this->response([], 'Firebase token saved successfully');
    }

}
