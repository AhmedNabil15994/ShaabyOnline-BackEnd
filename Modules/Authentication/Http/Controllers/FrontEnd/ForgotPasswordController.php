<?php

namespace Modules\Authentication\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Http\Requests\FrontEnd\ForgetPasswordRequest;
use Modules\Authentication\Notifications\FrontEnd\ResetPasswordNotification;
use Modules\Authentication\Repositories\FrontEnd\AuthenticationRepository as Authentication;

class ForgotPasswordController extends Controller
{
    function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function forgetPassword()
    {
        return view('authentication::frontend.auth.passwords.email');
    }

    public function sendForgetPassword(ForgetPasswordRequest $request)
    {
        $token = $this->auth->createToken($request);

        $token['user']->notify(new ResetPasswordNotification($token));

        return redirect()->back()->with(['status'=>__('authentication::frontend.password.alert.reset_sent')]);
    }
}
