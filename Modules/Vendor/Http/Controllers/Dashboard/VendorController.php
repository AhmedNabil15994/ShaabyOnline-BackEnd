<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Http\Requests\Dashboard\VendorProductsRequest;
use Modules\Vendor\Http\Requests\Dashboard\VendorRequest;
use Modules\Vendor\Transformers\Dashboard\SimpleVendorResource;
use Modules\Vendor\Transformers\Dashboard\VendorResource;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;

class VendorController extends Controller
{

    protected $vendor;

    function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function index()
    {
        return view('vendor::dashboard.vendors.index');
    }

    public function sorting()
    {
        $vendors = $this->vendor->getAll('sorting', 'ASC');
        return view('vendor::dashboard.vendors.sorting', compact('vendors'));
    }

    public function getAllActiveVendors()
    {
        $vendors = $this->vendor->getAllActive();
        return Response()->json([true, 'data' => SimpleVendorResource::collection($vendors)]);
    }

    public function storeSorting(Request $request)
    {
        $create = $this->vendor->sorting($request);

        if ($create) {
            return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
        }

        return Response()->json([false, __('apps::dashboard.general.message_error')]);
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->vendor->QueryTable($request));

        $datatable['data'] = VendorResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('vendor::dashboard.vendors.create');
    }

    public function store(VendorRequest $request)
    {
        try {
            $create = $this->vendor->create($request);

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
        abort(404);
        return view('vendor::dashboard.vendors.show');
    }

    public function edit($id)
    {
        $vendor = $this->vendor->findById($id);
        if (!$vendor)
            abort(404);

        return view('vendor::dashboard.vendors.edit', compact('vendor'));
    }

    public function update(VendorRequest $request, $id)
    {
        try {
            $update = $this->vendor->update($request, $id);

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
            if (!isset(config('setting.other')['is_multi_vendors']) || config('setting.other')['is_multi_vendors'] == 1) {

                $delete = $this->vendor->delete($id);

                if ($delete) {
                    return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
                }

                return Response()->json([false, __('apps::dashboard.general.message_error')]);
            } else
                return abort(404);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            if (!isset(config('setting.other')['is_multi_vendors']) || config('setting.other')['is_multi_vendors'] == 1) {

                if (empty($request['ids']))
                    return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);

                $deleteSelected = $this->vendor->deleteSelected($request);

                if ($deleteSelected) {
                    return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
                }

                return Response()->json([false, __('apps::dashboard.general.message_error')]);
            } else
                return abort(404);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function getAssignedProducts(Request $request, $id)
    {
        $vendor = $this->vendor->findById($id);
        $prodCategories = $this->vendor->getAllActiveProdCategories();
        $allProducts = $this->vendor->getAllPaginatedProducts($request);
        return view('vendor::dashboard.vendors.products', compact('vendor', 'allProducts', 'prodCategories'));
    }

    public function assignProducts(VendorProductsRequest $request, $id)
    {
        try {
            $vendor = $this->vendor->findById($id);
            if (!$vendor)
                return abort(404);

            $check = $this->vendor->assignVendorProducts($vendor, $request);

            if ($check) {
                return redirect()->back()->with('msg', __('apps::dashboard.general.message_update_success'));
            }

            return redirect()->back()->withErrors(__('apps::dashboard.general.message_error'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->errorInfo[2]);
        }
    }
}
