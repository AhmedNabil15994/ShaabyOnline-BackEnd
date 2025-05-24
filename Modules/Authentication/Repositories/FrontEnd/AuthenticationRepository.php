<?php

namespace Modules\Authentication\Repositories\FrontEnd;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\PasswordReset;
use Modules\User\Entities\User;

class AuthenticationRepository
{
    public function __construct(User $user, PasswordReset $password)
    {
        $this->password = $password;
        $this->user = $user;
    }

    public function register($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'name' => $request['name'],
                'email' => $request['email'] ?? null,
                'calling_code' => $request['calling_code'] ?? '965',
                'mobile' => $request['mobile'] ?? null,
                'password' => Hash::make($request['password']),
                'image' => '/uploads/users/user.png',
            ];
            $user = $this->user->create($data);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findUserByEmail($request)
    {
        return $this->user->where('email', $request->email)->first();
    }

    public function findUserByMobile($request)
    {
        return $this->user->where('mobile', $request->mobile)->first();
    }

    public function findUserByMobileOrEmail($request)
    {
        return $this->user->where('email', $request->email)->orWhere('mobile', $request->email)->first();
    }

    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);

        $this->deleteTokens($user);

        $newToken = strtolower(str_random(64));

        $token = $this->password->insert([
            'email' => $user->email,
            'token' => $newToken,
            'created_at' => Carbon::now(),
        ]);

        $data = [
            'token' => $newToken,
            'user' => $user,
        ];

        return $data;
    }

    public function resetPassword($request)
    {
        $user = $this->findUserByEmail($request);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $this->deleteTokens($user);

        return true;
    }

    public function deleteTokens($user)
    {
        $this->password->where('email', $user->email)->delete();
    }
}
