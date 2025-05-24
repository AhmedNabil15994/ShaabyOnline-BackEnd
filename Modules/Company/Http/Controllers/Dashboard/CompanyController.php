<?php

namespace Modules\Company\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Company\Http\Requests\Dashboard\CompanyRequest;
use Modules\Company\Transformers\Dashboard\CompanyResource;
use Modules\Company\Repositories\Dashboard\CompanyRepository as Company;

class CompanyController extends Controller
{
    protected $company;

    function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function index()
    {
        return view('company::dashboard.companies.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->company->QueryTable($request));

        $datatable['data'] = CompanyResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        if (config('setting.other.add_shipping_company') != 1)
            return abort(404);

        return view('company::dashboard.companies.create');
    }

    public function store(CompanyRequest $request)
    {
        if (config('setting.other.add_shipping_company') != 1)
            return abort(404);

        try {
            $create = $this->company->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('company::dashboard.companies.show');
    }

    public function edit($id)
    {
        $company = $this->company->findById($id);
        return view('company::dashboard.companies.edit', compact('company'));
    }

    public function clone($id)
    {
        $company = $this->company->findById($id);

        return view('company::dashboard.companies.clone', compact('company'));
    }

    public function update(CompanyRequest $request, $id)
    {
        try {
            $update = $this->company->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $count = $this->company->getAllCount();
            if ($count > 1) {
                $delete = $this->company->delete($id);

                if ($delete) {
                    return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
                }

                return Response()->json([false, __('apps::dashboard.general.message_error')]);
            }
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $count = $this->company->getAllCount();
            if ($count > 1) {
                $deleteSelected = $this->company->deleteSelected($request);
                if ($deleteSelected) {
                    return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
                }
                return Response()->json([false, __('apps::dashboard.general.message_error')]);
            }
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
