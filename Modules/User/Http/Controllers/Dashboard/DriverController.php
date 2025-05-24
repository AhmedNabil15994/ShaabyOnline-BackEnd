<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\DriverRequest;
use Modules\User\Transformers\Dashboard\DriverResource;
use Modules\User\Repositories\Dashboard\DriverRepository as Driver;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class DriverController extends Controller
{
    protected $role;
    protected $driver;

    function __construct(Driver $driver, Role $role)
    {
        $this->role = $role;
        $this->driver = $driver;
    }

    public function index()
    {
        return view('user::dashboard.drivers.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->driver->QueryTable($request));

        $datatable['data'] = DriverResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllDriversRoles('id', 'asc');
        return view('user::dashboard.drivers.create', compact('roles'));
    }

    public function store(DriverRequest $request)
    {
        try {
            $create = $this->driver->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('user::dashboard.drivers.show');
    }

    public function edit($id)
    {
        $user = $this->driver->findById($id);
        $roles = $this->role->getAllDriversRoles('id', 'asc');

        return view('user::dashboard.drivers.edit', compact('user', 'roles'));
    }

    public function update(DriverRequest $request, $id)
    {
        try {
            $update = $this->driver->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->driver->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->driver->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
