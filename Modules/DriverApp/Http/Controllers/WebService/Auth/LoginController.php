<?php

namespace Modules\DriverApp\Http\Controllers\WebService\Auth;

use Illuminate\Http\Request;
use Modules\DriverApp\Transformers\WebService\User\UserResource;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\DriverApp\Foundation\Authentication;
use Modules\DriverApp\Http\Requests\WebService\LoginRequest;

class LoginController extends WebServiceController
{
    use Authentication;

    public function postLogin(LoginRequest $request)
    {
        $failedAuth = $this->login($request);
        if ($failedAuth)
            return $this->invalidData($failedAuth, [], 422);

        return $this->tokenResponse();
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

    public function logout(Request $request)
    {
        $user = auth()->user()->token()->revoke();
        return $this->response([], __('driver_app::auth.logout.messages.success'));
    }
}
