<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\SellerRequest;
use Modules\User\Transformers\Dashboard\SellerResource;
use Modules\User\Repositories\Dashboard\SellerRepository as Seller;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class SellerController extends Controller
{
    protected $role;
    protected $seller;

    function __construct(Seller $seller, Role $role)
    {
        $this->role = $role;
        $this->seller = $seller;
    }

    public function index()
    {
        return view('user::dashboard.sellers.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->seller->QueryTable($request));

        $datatable['data'] = SellerResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllSellersRoles('id', 'asc');
        return view('user::dashboard.sellers.create', compact('roles'));
    }

    public function store(SellerRequest $request)
    {
        try {
            $create = $this->seller->create($request);

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
        return view('user::dashboard.sellers.show');
    }

    public function edit($id)
    {
        $user = $this->seller->findById($id);
        $roles = $this->role->getAllSellersRoles('id', 'asc');

        return view('user::dashboard.sellers.edit', compact('user', 'roles'));
    }

    public function update(SellerRequest $request, $id)
    {
        try {
            $update = $this->seller->update($request, $id);

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
            $delete = $this->seller->delete($id);

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
            $deleteSelected = $this->seller->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
