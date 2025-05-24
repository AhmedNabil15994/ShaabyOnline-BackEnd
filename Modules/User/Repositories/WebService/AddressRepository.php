<?php

namespace Modules\User\Repositories\WebService;

use Modules\User\Entities\Address;
use Illuminate\Support\Facades\DB;

class AddressRepository
{
    protected $address;

    function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function getAllByUsrId()
    {
        $authUserId = auth('api')->user() ? auth('api')->user()->id : null;
        return $this->address->with('state')
            ->when(!is_null($authUserId), function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            })
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function findById($id)
    {
        $authUserId = auth('api')->user() ? auth('api')->user()->id : null;
        return $this->address->with('state')
            ->when(!is_null($authUserId), function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            })
            ->find($id);
    }

    public function findByIdWithoutAuth($id)
    {
        $address = $this->address->with('state')->find($id);
        return $address;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $authUserId = auth('api')->user() ? auth('api')->user()->id : null;

            $address = $this->address->create([
                'email' => $request['email'] ?? auth('api')->user()->email,
                'username' => $request['username'] ?? auth('api')->user()->name,
                'mobile' => $request['mobile'] ?? auth('api')->user()->mobile,
                'address' => $request['address'],
                'block' => $request['block'],
                'street' => $request['street'],
                'building' => $request['building'],
                'state_id' => $request['state_id'],
                'user_id' => $authUserId,
                'avenue' => $request['avenue'] ?? null,
                'floor' => $request['floor'] ?? null,
                'flat' => $request['flat'] ?? null,
                'automated_number' => $request['automated_number'] ?? null,
            ]);

            DB::commit();
            return $address;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $address)
    {
        DB::beginTransaction();

        try {

            $address->update([
                'email' => $request['email'] ?? auth('api')->user()->email,
                'username' => $request['username'] ?? auth('api')->user()->name,
                'mobile' => $request['mobile'] ?? auth('api')->user()->mobile,
                'address' => $request['address'],
                'block' => $request['block'],
                'street' => $request['street'],
                'building' => $request['building'],
                'state_id' => $request['state_id'],
                'avenue' => $request['avenue'] ?? null,
                'floor' => $request['floor'] ?? null,
                'flat' => $request['flat'] ?? null,
                'automated_number' => $request['automated_number'] ?? null
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function makeDefaultAddress($request, $id)
    {
        DB::beginTransaction();

        try {

            $this->address->where('user_id', auth('api')->id())->update(['is_default' => 0]);
            $this->address->where('user_id', auth('api')->id())->where('id', $id)->update(['is_default' => 1]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);
            $model->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
