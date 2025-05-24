<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\UserAddressRequest;
use Modules\User\Transformers\Dashboard\UserAddressResource;
use Modules\User\Repositories\Dashboard\AddressRepository as Address;

class AddressController extends Controller
{
    protected $address;

    function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function index()
    {
        abort(404);
        return view('user::dashboard.addresses.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->address->QueryTable($request));
        $datatable['data'] = UserAddressResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        abort(404);
        return view('user::dashboard.addresses.create');
    }

    public function store(UserAddressRequest $request)
    {
        try {
            $create = $this->address->create($request);

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
        $address = $this->address->findById($id);
        if (!$address)
            abort(404);

        return view('user::dashboard.addresses.show', compact('address'));
    }

    public function edit($id)
    {
        $address = $this->address->findById($id);
        if (!$address)
            abort(404);

        return view('user::dashboard.addresses.edit', compact('address'));
    }

    public function update(UserAddressRequest $request, $id)
    {
        try {
            $update = $this->address->update($request, $id);

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
            $delete = $this->address->delete($id);

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
            $deleteSelected = $this->address->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
