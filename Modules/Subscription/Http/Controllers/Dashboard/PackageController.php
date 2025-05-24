<?php

namespace Modules\Subscription\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Subscription\Http\Requests\Dashboard\PackageRequest;
use Modules\Subscription\Transformers\Dashboard\PackageResource;
use Modules\Subscription\Repositories\Dashboard\PackageRepository as Package;

class PackageController extends Controller
{

    function __construct(Package $package)
    {
        $this->package = $package;
    }

    public function index()
    {
        return view('subscription::dashboard.packages.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->package->QueryTable($request));

        $datatable['data'] = PackageResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('subscription::dashboard.packages.create');
    }

    public function store(PackageRequest $request)
    {
        try {
            $create = $this->package->create($request);

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
        return view('subscription::dashboard.packages.show');
    }

    public function edit($id)
    {
        $package = $this->package->findById($id);

        return view('subscription::dashboard.packages.edit', compact('package'));
    }

    public function update(PackageRequest $request, $id)
    {
        try {
            $update = $this->package->update($request, $id);

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
            $delete = $this->package->delete($id);

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
            $deleteSelected = $this->package->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
