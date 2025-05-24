<?php

namespace Modules\User\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Core\Traits\CoreTrait;
use Modules\User\Entities\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AddressRepository
{
    use CoreTrait;

    protected $address;

    function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $users = $this->address->orderBy($order, $sort)->get();
        return $users;
    }

    /*
    * Find Object By ID
    */
    public function findById($id, $with = [])
    {
        $user = $this->address->query();
        if ($with) {
            $user = $user->with($with);
        }
        return $user->find($id);
    }

    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
            $address = $this->address->create([
                'email' => $request['email'] ?? null,
                'username' => $request['username'] ?? null,
                'mobile' => $request['mobile'] ?? null,
                'address' => $request['address'],
                'block' => $request['block'],
                'street' => $request['street'],
                'building' => $request['building'],
                'state_id' => $request['state'],
                'user_id' => $request['user_id'],
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

    /*
    * Find Object By ID & Update to DB
    */
    public function update($request, $id)
    {
        DB::beginTransaction();

        $address = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($address) : null;

        try {

            $address->update([
                'email' => $request['email'] ?? null,
                'username' => $request['username'] ?? null,
                'mobile' => $request['mobile'] ?? null,
                'address' => $request['address'],
                'block' => $request['block'],
                'street' => $request['street'],
                'building' => $request['building'],
                'state_id' => $request['state'],
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

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);
            if ($model) {
                if (!empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                    File::delete($model->image); ### Delete old image
                }
                $model->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find all Objects By IDs & Delete it from DB
    */
    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            if (!empty($request['ids'])) {
                foreach ($request['ids'] as $id) {
                    $model = $this->delete($id);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->address->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('username', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
        });

        if (!is_null($request->user_id)) {
            $query = $query->where('user_id', $request->user_id);
        }

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query, $request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        return $query;
    }
}
