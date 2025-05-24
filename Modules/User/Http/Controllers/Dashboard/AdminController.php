<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\AdminRequest;
use Modules\User\Transformers\Dashboard\AdminResource;
use Modules\User\Repositories\Dashboard\AdminRepository as Admin;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class AdminController extends Controller
{

    function __construct(Admin $admin , Role $role)
    {
        $this->role = $role;
        $this->admin = $admin;
    }

    public function index()
    {
        return view('user::dashboard.admins.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->admin->QueryTable($request));

        $datatable['data'] = AdminResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllAdminsRoles('id','asc');
        return view('user::dashboard.admins.create',compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $create = $this->admin->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('user::dashboard.admins.show');
    }

    public function edit($id)
    {
        $user = $this->admin->findById($id);
        $roles = $this->role->getAllAdminsRoles('id','asc');

        return view('user::dashboard.admins.edit',compact('user','roles'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $update = $this->admin->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->admin->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->admin->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
