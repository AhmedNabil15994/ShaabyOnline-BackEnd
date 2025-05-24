<?php

namespace Modules\DriverApp\Repositories\WebService;

use Modules\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function update($request)
    {
        $user = auth('api')->user();

        if ($request['password'] == null)
            $password = $user['password'];
        else
            $password = Hash::make($request['password']);

        DB::beginTransaction();

        try {

            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'password' => $password,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findById($id)
    {
        return $this->user->find($id);
    }

    public function changePassword($request)
    {
        $user = $this->findById(auth('api')->id());

        if ($request['password'] == null)
            $password = $user['password'];
        else
            $password = Hash::make($request['password']);

        DB::beginTransaction();

        try {

            $user->update([
                'password' => $password,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function userProfile()
    {
        return auth('api')->user();
    }

    public function getAllAdmins()
    {
        return $this->user->whereHas('roles.perms', function ($query) {
            $query->where('name', 'dashboard_access');
        })->get();
    }

    public function getAllDrivers()
    {
        return $this->user->whereHas('roles.perms', function ($query) {
            $query->where('name', 'driver_access');
        })->get();
    }
}
