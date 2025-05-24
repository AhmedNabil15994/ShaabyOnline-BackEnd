<?php

namespace Modules\Area\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Area\Http\Requests\Dashboard\CityRequest;
use Modules\Area\Transformers\Dashboard\CityResource;
use Modules\Area\Repositories\Dashboard\CityRepository as City;

class CityController extends Controller
{
    protected $city;

    function __construct(City $city)
    {
        $this->city = $city;
    }

    public function index()
    {
        return view('area::dashboard.cities.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->city->QueryTable($request));
        $datatable['data'] = CityResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('area::dashboard.cities.create');
    }

    public function store(CityRequest $request)
    {
        try {
            $create = $this->city->create($request);

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
        return view('area::dashboard.cities.show');
    }

    public function edit($id)
    {
        $city = $this->city->findById($id);
        if (!$city)
            abort(404);

        return view('area::dashboard.cities.edit', compact('city'));
    }

    public function update(CityRequest $request, $id)
    {
        try {
            $update = $this->city->update($request, $id);

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
            $delete = $this->city->delete($id);

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
            $deleteSelected = $this->city->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
