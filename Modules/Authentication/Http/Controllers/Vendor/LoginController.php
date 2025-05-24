<?php

namespace Modules\Authentication\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Vendor\LoginRequest;

class LoginController extends Controller
{
    use Authentication;

    /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {
        return view('authentication::vendor.auth.login');
    }

    /**
     * Login method
     */
    public function postLogin(LoginRequest $request)
    {
        $errors =  $this->login($request);

        if ($errors)
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));

        return redirect()->route('vendor.home');
    }


    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('vendor.home');
    }

}
