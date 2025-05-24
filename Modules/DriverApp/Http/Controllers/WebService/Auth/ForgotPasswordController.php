<?php

namespace Modules\DriverApp\Http\Controllers\WebService\Auth;

use Illuminate\Http\Request;
use Modules\User\Transformers\WebService\UserResource;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\DriverApp\Http\Requests\WebService\ForgetPasswordRequest;
use Modules\DriverApp\Notifications\WebService\ResetPasswordNotification;
use Modules\DriverApp\Repositories\WebService\AuthenticationRepository as Authentication;

class ForgotPasswordController extends WebServiceController
{
    function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $token = $this->auth->createToken($request);
        $token['user']->notify((new ResetPasswordNotification($token))->locale(locale()));
        return $this->response([], __('driver_app::auth.forget_password.messages.success') );
    }
}
