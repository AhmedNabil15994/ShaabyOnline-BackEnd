<?php

namespace Modules\Authentication\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Http\Requests\Dashboard\ForgetPasswordRequest;
use Modules\Authentication\Notifications\FrontEnd\ResetPasswordNotification;
use Modules\Authentication\Repositories\Dashboard\AuthenticationRepository as Authentication;

class ForgotPasswordController extends Controller
{
    protected $auth;

    function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function forgetPassword()
    {
        return view('authentication::dashboard.auth.passwords.email');
    }

    public function sendForgetPassword(ForgetPasswordRequest $request)
    {
        $token = $this->auth->createToken($request);
        $token['user']->notify(new ResetPasswordNotification($token, 'dashboard'));
        return redirect()->back()->with(['status' => __('authentication::dashboard.password.alert.reset_sent')]);
    }
}
