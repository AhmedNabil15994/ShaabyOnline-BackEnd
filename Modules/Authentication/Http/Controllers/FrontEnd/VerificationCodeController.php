<?php

namespace Modules\Authentication\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Authentication\Http\Requests\FrontEnd\VerificationCodeRequest;
use Modules\Authentication\Repositories\FrontEnd\VerificationCodeRepository;
use Modules\Authentication\Repositories\FrontEnd\AuthenticationRepository;
use Modules\Authentication\Traits\AuthenticationTrait;
use Modules\Catalog\Traits\ShoppingCartTrait;

class VerificationCodeController extends Controller
{
    use ShoppingCartTrait, AuthenticationTrait;

    protected $verificationCode;
    protected $auth;

    public function __construct(VerificationCodeRepository $verificationCode, AuthenticationRepository $auth)
    {
        $this->verificationCode = $verificationCode;
        $this->auth = $auth;
    }

    public function getVerificationCode(Request $request)
    {
        if ($request->type == 'profile'){
            $requestParams = $this->sendVerificationCode($request, auth()->user());
        }
        return view('authentication::frontend.verification_code');
    }

    public function checkVerificationCode(VerificationCodeRequest $request)
    {
        if (auth()->guest()) {
            $user = $this->auth->findUserByMobile($request);
            if (!$user)
                return redirect()->back()->withErrors(['mobile' => __('authentication::frontend.verification_code.validation.mobile.exists')]);
        } else {
            $user = auth()->user();
        }

        $userCode = $this->verificationCode->findMobileCode($user, $request);
        if (!$userCode)
            return redirect()->back()->withErrors(['verification_code' => __('authentication::frontend.verification_code.validation.verification_code.exists')]);

        // update user mobile_verified_at
        $user->update([
            'mobile_verified_at' => date('Y-m-d H:i:s'),
        ]);

        // login user
        Auth::login($user);

        if (isset($request->type) && $request->type == 'checkout') {
            $this->removeCartConditionByType('company_delivery_fees', get_cookie_value(config('core.config.constants.CART_KEY')));
            $this->updateCartKey(get_cookie_value(config('core.config.constants.CART_KEY')), $user->id);
            return redirect()->route('frontend.checkout.index');
        } elseif ($request->type == 'profile') {
            return redirect()->route('frontend.profile.index', ['mobile' => $request->mobile]);
        }

        return redirect()->route('frontend.home');
    }

}
