<?php

namespace Modules\User\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\User\Transformers\WebService\UserResource;
use Modules\User\Http\Requests\WebService\UpdateProfileRequest;
use Modules\User\Repositories\WebService\UserRepository as User;
use Modules\User\Http\Requests\WebService\ChangePasswordRequest;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Illuminate\Support\Str;

class UserController extends WebServiceController
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        $user = $this->user->userProfile();
        if (is_null($user)) {
            return $this->error(__('Please login again'), [], 401);
        }
        return $this->response(new UserResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth('api')->user();
        if (is_null($user)) {
            return $this->error(__('Please login again'), [], 401);
        }
        $this->user->update($request);
        $user = $this->user->userProfile();
        return $this->response(new UserResource($user));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->changePassword($request);
        $user = $this->user->findById(auth()->id());
        return $this->response(new UserResource($user));
    }

    public function getVerifidCode(Request $request)
    {
        $columns = [
            'calling_code' => $request->calling_code ?? '965',
            'mobile' => $request->mobile,
        ];
        $user = $this->user->findUserByMultipleColumns($columns);
        return $this->response(["code" => optional($user)->code_verified ?? ""]);
    }

    public function deleteUserAccount(Request $request)
    {
        $user = $this->user->findById(auth()->id());
        if (!$user) {
            return $this->error(__('user::api.users.alerts.user_not_found'));
        }
        $prefix = 'toc_' . $user->id . '_';

        if (Str::startsWith($user->email, $prefix) || Str::startsWith($user->mobile, $prefix))
            return $this->error(__('user::api.users.alerts.user_deleted_before'));

        $email = $prefix . $user->email;
        $mobile = $prefix . $user->mobile;

        $user->update([
            'email' => $email,
            'mobile' => $mobile,
        ]);
        // $user->fresh();
        auth()->user()->token()->revoke(); // logout user
        return $this->response([], __('user::api.users.alerts.user_deleted_successfully'));
    }
}
