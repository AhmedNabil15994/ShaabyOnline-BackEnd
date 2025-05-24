<?php

namespace Modules\DriverApp\Http\Controllers\WebService\Auth;

use Illuminate\Http\Request;
use Modules\DriverApp\Transformers\WebService\User\UserResource;
use Modules\DriverApp\Http\Requests\WebService\User\UpdateProfileRequest;
use Modules\DriverApp\Repositories\WebService\UserRepository as User;
use Modules\DriverApp\Http\Requests\WebService\User\ChangePasswordRequest;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

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
        return $this->response(new UserResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
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
}
