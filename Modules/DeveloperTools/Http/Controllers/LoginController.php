<?php

namespace Modules\DeveloperTools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DeveloperTools\Foundation\Authentication;
use Modules\DeveloperTools\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    use Authentication;

    /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {
        return view('developertools::auth.login');
    }

    /**
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        $errors =  $this->login($request);

        if ($errors)
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));

        return redirect()->route('developer.home');
    }


    /**
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        auth('developer')->logout();
        return redirect('/');
    }

}
