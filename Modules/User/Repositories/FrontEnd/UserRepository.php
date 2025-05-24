<?php

namespace Modules\User\Repositories\FrontEnd;

use DB;
use Hash;
use Modules\User\Entities\User;
use Modules\User\Entities\UserFavourite;

class UserRepository
{
    protected $user;
    protected $favourite;

    public function __construct(User $user, UserFavourite $favourite)
    {
        $this->user = $user;
        $this->favourite = $favourite;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $user = $this->user->find($id);
        $restore = $request->restore ? $this->restoreSoftDelte($user) : null;

        try {
            $image = $request['image'] ? path_without_domain($request['image']) : $user->image;

            if ($request['password'] == null) {
                $password = $user['password'];
            } else {
                $password = Hash::make($request['password']);
            }

            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'country_code' => $request['country_code'],
                'password' => $password,
                'image' => $image,
            ];
            if (isset($request['mobile_verified_at']))
                $data['mobile_verified_at'] = $request['mobile_verified_at'];

            /*if (isset($request['firebase_id']))
                $data['firebase_id'] = $request['firebase_id'];*/

            $user->update($data);

            if ($request['roles'] != null) {
                DB::table('role_user')->where('user_id', $id)->delete();

                foreach ($request['roles'] as $key => $value) {
                    $user->attachRole($value);
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findFavourite($userId, $prdId)
    {
        return $this->favourite->where(function ($q) use ($userId, $prdId) {
            $q->where('user_id', $userId);
            $q->where('product_id', $prdId);
        })->first();
    }

    public function createFavourite($userId, $prdId)
    {
        return $this->favourite->create([
            'user_id' => $userId,
            'product_id' => $prdId,
        ]);
    }

}
