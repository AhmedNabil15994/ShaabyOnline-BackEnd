<?php

namespace Modules\Authorization\Repositories\Dashboard;

use Illuminate\Support\Str;
use Modules\Authorization\Entities\Role;
use Illuminate\Support\Facades\DB;

class RoleRepository
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $roles = $this->role->orderBy($order, $sort)->get();
        return $roles;
    }

    public function getAllDriversRoles($order = 'id', $sort = 'desc')
    {
        $roles = $this->role->whereHas('perms', function ($query) {
            $query->where('name', 'driver_access');
        })->orderBy($order, $sort)->get();
        return $roles;
    }

    public function getAllAdminsRoles($order = 'id', $sort = 'desc')
    {
        $roles = $this->role->whereHas('perms', function ($query) {
            $query->where('name', 'dashboard_access');
        })->orderBy($order, $sort)->get();
        return $roles;
    }

    public function getAllSellersRoles($order = 'id', $sort = 'desc')
    {
        $roles = $this->role->whereHas('perms', function ($query) {
            $query->where('name', 'seller_access');
        })->orderBy($order, $sort)->get();
        return $roles;
    }

    public function findById($id)
    {
        try {
            $role = $this->role->findOrFail($id);
            return $role;
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function findByName($name, $exceptId = null)
    {
        return $this->role->where('name', $name)
            ->when(!is_null($exceptId), function ($query) use ($exceptId) {
                $query->where('id', '<>', $exceptId);
            })
            ->first();
    }

    public function create($request, $roleName)
    {
        DB::beginTransaction();

        try {
            $role = $this->role->create([
                'name'          => $roleName,
                "display_name"  => $request->display_name,
                "description"   => $request->description,
            ]);

            foreach ($request['permission'] as $key => $value) {
                $role->attachPermission($value);
            }

          

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id, $roleName)
    {
        DB::beginTransaction();

        try {
            $role = $this->findById($id);

            $role->update([
                'name' => $roleName,
                "display_name"  => $request->display_name,
                "description"   => $request->description,
            ]);

            DB::table('permission_role')->where('role_id', $id)->delete();

            foreach ($request['permission'] as $key => $value) {
                $role->attachPermission($value);
            }

        

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function translateTable($model, $request)
    {
        foreach ($request['display_name'] as $locale => $value) {
            $model->translateOrNew($locale)->display_name = $value;
            if (isset($request['description'][$locale]) && !empty($request['description'][$locale])) {
                $model->translateOrNew($locale)->description = $request['description'][$locale];
            }
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $this->role->whereId($id)->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $this->role->whereId($id)->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->role->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('display_name', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        return $query;
    }
}
