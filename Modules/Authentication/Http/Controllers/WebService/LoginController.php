<?php

namespace Modules\Authentication\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Authentication\Http\Requests\WebService\ResendCodeRequest;
use Modules\Authentication\Http\Requests\WebService\VerifiedCodeRequest;
use Modules\Authentication\Repositories\WebService\AuthenticationRepository;
use Modules\User\Transformers\WebService\UserResource;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\WebService\LoginRequest;

class LoginController extends WebServiceController
{
    use Authentication;

    protected $user;

    public function __construct(AuthenticationRepository $user)
    {
        $this->user = $user;
    }

    public function postLogin(LoginRequest $request)
    {
        $failedAuth = $this->login($request);

        if ($failedAuth)
            return $this->invalidData($failedAuth, [], 422);

        return $this->tokenResponse();
    }

    public function tokenResponse($user = null)
    {
        $user = $user ?? auth()->user();
        $token = $this->generateToken($user);
        return $this->response([
            'access_token' => $token->accessToken,
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
            'expires_at' => $this->tokenExpiresAt($token)
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user()->token()->revoke();
        return $this->response([], __('authentication::api.logout.messages.success'));
    }

    public function resendCode(ResendCodeRequest $request)
    {
        /*if (auth('api')->guest()) {
            $codeVerified = generateRandomNumericCode();
            if ($this->user->resendCodeToGuestUser($request, $codeVerified)) {
                return $this->response([
                    "code_verified" => config("app.env") != "production" ? $codeVerified : null
                ], __('authentication::api.resend.success'));
            }
            return $this->error(__('authentication::api.register.messages.error_sms'), [], 420);
        } else {
        }*/

        $user = $this->user->findUser($request->mobile, $request->calling_code);
        if ($user) {
            if ($this->user->resendCode($user)) {
                return $this->response([
                    "code_verified" => config("app.env") != "production" ? $user->code_verified : null
                ], __('authentication::api.resend.success'));
            }
            return $this->error(__('authentication::api.register.messages.error_sms'), [], 420);
        }

        return $this->error(__('authentication::api.register.messages.failed'), [], 401);
    }

    public function verified(VerifiedCodeRequest $request)
    {
        $user = $this->user->findUser($request->mobile, $request->calling_code);
        if ($user) {
            if ($user->code_verified == $request->code) {
                $user->update(["code_verified" => null, "is_verified" => true]);
                // if not get token needed
                if ($request->not_get_token) {
                    return $this->response([
                        'user' => new UserResource($user),
                    ]);
                }
                return $this->tokenResponse($user);
            }
            return $this->error(__('authentication::api.register.messages.code'), [], 420);
        }

        return $this->error(__('authentication::api.register.messages.failed'), [], 401);
    }
}
