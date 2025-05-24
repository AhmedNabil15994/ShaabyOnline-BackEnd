<?php

namespace Modules\Authentication\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Dashboard\ResetPasswordRequest;
use Modules\Authentication\Repositories\Dashboard\AuthenticationRepository as AuthenticationRepo;
use Modules\User\Entities\PasswordReset;

class ResetPasswordController extends Controller
{
    use Authentication;
    protected $auth;

    function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function resetPassword($token)
    {
        abort_unless(PasswordReset::where('token', $token)->first(), 419);
        abort_unless(PasswordReset::where([
            'token' => $token,
            'email' => request('email'),
        ])->first(), 419);

        return view('authentication::dashboard.auth.passwords.reset', compact('token'));
    }


    public function updatePassword(ResetPasswordRequest $request)
    {
        abort_unless(PasswordReset::where('token', $request->token)->first(), 419);
        abort_unless(PasswordReset::where([
            'token' => $request->token,
            'email' => $request->email,
        ])->first(), 419);

        $reset = $this->auth->resetPassword($request);
        $errors = $this->login($request);
        if ($errors)
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));

        return redirect()->route('dashboard.home')->with(['status' => 'Password Reset Successfully']);
    }
}
