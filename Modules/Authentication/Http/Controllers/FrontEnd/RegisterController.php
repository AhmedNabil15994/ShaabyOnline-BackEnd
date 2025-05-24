<?php

namespace Modules\Authentication\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\FrontEnd\RegisterRequest;
use Modules\Authentication\Repositories\FrontEnd\AuthenticationRepository as AuthenticationRepo;
use Modules\Authentication\Traits\AuthenticationTrait;
use Modules\Catalog\Traits\ShoppingCartTrait;

class RegisterController extends Controller
{
    use Authentication, ShoppingCartTrait, AuthenticationTrait;

    protected $auth;

    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function show()
    {
        return view('authentication::frontend.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $registered = $this->auth->register($request);
        if ($registered) {

            /*// send verification code to user mobile.
            if ($request['mobile']) {
                $requestParams = $this->sendVerificationCode($request, $registered);
                if ($requestParams != false)
                    return redirect()->route('frontend.get_verification_code', $requestParams);

                return redirect()->back()->with(['errors' => __('authentication::frontend.verification_code.messages.unable_to_send_verification_code')]);
            }*/

            $this->loginAfterRegister($request);
            if (isset($request->type) && $request->type == 'checkout') {
                $this->removeCartConditionByType('company_delivery_fees', get_cookie_value(config('core.config.constants.CART_KEY')));
                $this->updateCartKey(get_cookie_value(config('core.config.constants.CART_KEY')), $registered->id);
                return redirect()->route('frontend.checkout.index');
            }
            return redirect()->route('frontend.home');
        } else
            return redirect()->back()->with(['errors' => 'try again']);
    }

}
