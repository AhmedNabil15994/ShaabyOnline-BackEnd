<?php

namespace Modules\Authorization\Repositories\Dashboard;

use Modules\Authorization\Entities\Permission;
use DB;

class PermissionRepository
{
    function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $permissions = $this->permission->orderBy($order, $sort)->get();
        return $permissions;
    }

    public function findById($id)
    {
        try {

            $permission = $this->permission->findOrFail($id);
            return $permission;

        } catch (\Exception $e) {

            return abort(404);

        }

    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $perm = $this->permission->create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                "description"   => $request->description,
            ]);

           

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        try {

            $perm = $this->findById($id);

            $perm->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                "description"   => $request->description,
            ]);

            // $this->translateTable($perm, $request);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

   
    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $this->findById($id)->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return true;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            $this->permission->destroy($request['ids']);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->permission->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('display_name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = self::filterDataTable($query, $request);

        return $query;
    }

    public static function filterDataTable($query, $request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        return $query;
    }
}
