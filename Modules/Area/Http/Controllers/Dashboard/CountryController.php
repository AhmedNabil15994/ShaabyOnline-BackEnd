<?php

namespace Modules\Area\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Area\Http\Requests\Dashboard\CountryRequest;
use Modules\Area\Transformers\Dashboard\CountryResource;
use Modules\Area\Repositories\Dashboard\CountryRepository as Country;

class CountryController extends Controller
{
    protected $country;

    function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function index()
    {
        return view('area::dashboard.countries.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->country->QueryTable($request));
        $datatable['data'] = CountryResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('area::dashboard.countries.create');
    }

    public function store(CountryRequest $request)
    {
        try {
            $create = $this->country->create($request);

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
        return view('area::dashboard.countries.show');
    }

    public function edit($id)
    {
        $country = $this->country->findById($id);

        return view('area::dashboard.countries.edit', compact('country'));
    }

    public function update(CountryRequest $request, $id)
    {
        try {
            $update = $this->country->update($request, $id);

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
            $delete = $this->country->delete($id);

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
            $deleteSelected = $this->country->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
