<?php

namespace Modules\Authentication\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Repositories\FrontEnd\AuthenticationRepository;
use Modules\Authentication\Traits\AuthenticationTrait;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\FrontEnd\LoginRequest;

class LoginController extends Controller
{
    use Authentication, AuthenticationTrait, ShoppingCartTrait;

    protected $auth;

    public function __construct(AuthenticationRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     */
    public function showLogin(Request $request)
    {
        return view('authentication::frontend.auth.login-signup', compact('request'));
    }

    /**
     * Login method
     */
    public function postLogin(LoginRequest $request)
    {
        /*// check if user mobile verified or not based on `mobile_verified_at` && `firebase_id`
        $user = $this->auth->findUserByMobileOrEmail($request);
        if (!$user)
            return redirect()->back()->withErrors(['email' => __('authentication::frontend.login.validation.email.exists')]);

        if ($user->mobile && is_null($user->mobile_verified_at) && is_null($user->firebase_id)) {
            // redirect to verification page
            $request->request->add(['mobile' => $request->email]);
            $requestParams = $this->sendVerificationCode($request, $user);
            if ($requestParams != false)
                return redirect()->route('frontend.get_verification_code', $requestParams);

            return redirect()->back()->with(['errors' => __('authentication::frontend.verification_code.messages.unable_to_send_verification_code')]);
        }*/

        $errors = $this->login($request);
        if ($errors)
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));

        return $this->redirectTo($request);
    }


    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        $this->clearCart();
        auth()->logout();
        return $this->redirectTo($request);
    }


    public function redirectTo($request)
    {
        if ($request['redirect_to'] == 'address')
            return redirect()->route('frontend.order.address.index');

        return redirect()->route('frontend.home');
    }

}
