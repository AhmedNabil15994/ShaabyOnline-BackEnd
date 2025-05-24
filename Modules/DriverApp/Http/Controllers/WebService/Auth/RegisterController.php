<?php

namespace Modules\DriverApp\Http\Controllers\WebService\Auth;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\User\Transformers\WebService\UserResource;
use Modules\DriverApp\Foundation\Authentication;
use Modules\DriverApp\Http\Requests\WebService\RegisterRequest;
use Modules\DriverApp\Repositories\WebService\AuthenticationRepository as AuthenticationRepo;

class RegisterController extends WebServiceController
{
    use Authentication;

    protected $auth;

    function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request)
    {
        $registered = $this->auth->register($request);

        if ($registered) {
            $this->loginAfterRegister($request);
            return $this->tokenResponse();
        } else {
            return $this->error(__('driver_app::auth.register.messages.failed'), [], 401);
        }

    }

    public function tokenResponse($user = null)
    {
        $user = $user ? $user : auth()->user();

        $token = $this->generateToken($user);

        return $this->response([
            'access_token' => $token->accessToken,
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
            'expires_at' => $this->tokenExpiresAt($token)
        ]);
    }
}
