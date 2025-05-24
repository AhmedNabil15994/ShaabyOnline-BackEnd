<?php

namespace Modules\Authentication\Http\Controllers\WebService;

use Illuminate\Support\Facades\DB;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\WebService\RegisterRequest;
use Modules\Authentication\Repositories\WebService\AuthenticationRepository as AuthenticationRepo;
use Modules\Cart\Traits\CartTrait;
use Modules\User\Transformers\WebService\UserResource;

class RegisterController extends WebServiceController
{
    use Authentication, CartTrait;

    protected $auth;

    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $registered = $this->auth->register($request);
            $sendSms = false;
            if ($registered) {
                if (config("app.have_sms")) {
                    $sendSms = $this->auth->sendSms($registered);
                }

                if ($request->address) {
                    // create user address if exist
                    $this->auth->createUserAddress($registered->id, $request->address);
                }

                if (isset($request->user_token) && !is_null($request->user_token)) {
                    $this->updateCartKey($request->user_token, $registered->id);
                }
                DB::commit();
                return $this->responseData($registered, $sendSms);
            } else {
                return $this->error(__('authentication::api.register.messages.failed'), [], 401);
            }
        } catch (\Exception$e) {
            DB::rollback();
            throw $e;
        }
    }

    public function responseData($user = null, $sms_sent = false)
    {
        $user = $user ? $user : auth()->user();
        $token = $this->generateToken($user);

        return $this->response([
            'access_token' => $token->accessToken,
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
            'expires_at' => $this->tokenExpiresAt($token),
            "sms_send" => $sms_sent,
            "code_verified" => $user->code_verified,
        ]);
    }

    /*public function registerOld(RegisterRequest $request)
{
$registered = $this->auth->register($request);

if ($registered) {
$this->loginAfterRegister($request);
if (isset($request->user_token) && !is_null($request->user_token)) {
$this->removeCartConditionByType('company_delivery_fees', $request->user_token);
$this->updateCartKey($request->user_token, $registered->id);
}
return $this->tokenResponse($registered);
} else {
return $this->error(__('authentication::api.register.messages.failed'), [], 401);
}

}

public function tokenResponseOld($user = null)
{
$user = $user ?? auth()->user();
$token = $this->generateToken($user);

return $this->response([
'access_token' => $token->accessToken,
'user' => new UserResource($user),
'token_type' => 'Bearer',
'expires_at' => $this->tokenExpiresAt($token)
]);
}*/

}
