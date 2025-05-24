<?php

namespace Modules\Authentication\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Dashboard\LoginRequest;
use Modules\Authentication\Repositories\Dashboard\AuthenticationRepository as AuthenticationRepo;

class LoginController extends Controller
{
    use Authentication;

    protected $authentication;

    public function __construct(AuthenticationRepo $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {
        return view('authentication::dashboard.auth.login');
    }

    /**
     * Login method
     */
    public function postLogin(LoginRequest $request)
    {
        $user = $this->authentication->findUserByEmail($request);
        if ($user && $user->can('dashboard_access') == false) {
            return redirect()->back()->with(['alert' => 'danger', 'status' => __('authentication::dashboard.login.validations.do_not_have_access')])->withInput($request->except('password'));
        }
        $errors = $this->login($request);
        if ($errors) {
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));
        }
        return redirect()->route('dashboard.home');
    }

    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('dashboard.home');
    }

}
