<?php

namespace Modules\Authentication\Repositories\FrontEnd;

use Illuminate\Support\Facades\DB;
use Modules\User\Entities\UserMobileCode;

class VerificationCodeRepository
{
    protected $code;

    public function __construct(UserMobileCode $code)
    {
        $this->code = $code;
    }

    public function findMobileCode($user, $request)
    {
        return $this->code->where('code', $request->verification_code)
            ->where('user_id', $user->id)
            ->first();
    }
}
