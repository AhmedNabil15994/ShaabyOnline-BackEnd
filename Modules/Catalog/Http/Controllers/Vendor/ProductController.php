<?php

namespace Modules\Catalog\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Catalog\Http\Requests\Vendor\ProductRequest;
use Modules\Catalog\Http\Requests\Vendor\AddOnsRequest;
use Modules\Catalog\Transformers\Vendor\ProductResource;
use Modules\Catalog\Repositories\Vendor\ProductRepository as Product;

class ProductController extends Controller
{
    protected $product;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return view('catalog::vendor.products.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->product->QueryTable($request));

        $datatable['data'] = ProductResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('catalog::vendor.products.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            $create = $this->product->create($request);

            if ($create) {
                return Response()->json([true, __('apps::vendor.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('catalog::vendor.products.show');
    }

    public function edit($id)
    {
        $product = $this->product->findById($id);
        $product->load(["variantValues", "variants.productValues.optionValue.option", "categories"]);
        $currentVaration = $product->variantValues->sortBy("option_value_id")->groupBy("product_variant_id")->pluck("*.option_value_id")->toArray();

        return view('catalog::vendor.products.edit', compact('product', "currentVaration"));
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $update = $this->product->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::vendor.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->product->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::vendor.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            if (empty($request['ids']))
                return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);

            $deleteSelected = $this->product->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::vendor.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    // addone
    public function addOns($id)
    {
        if (config('setting.products.toggle_addons') != 1)
            return abort(404);

        $product = $this->product->findById($id);
        if (!$product)
            return abort(404);

        return view('catalog::vendor.products.add_ons', compact('product'));
    }

    public function storeAddOns($id, AddOnsRequest $request)
    {
        try {
            $create = $this->product->createAddOns($request, $id);

            if ($create) {
                return Response()->json([true, __('apps::vendor.general.message_create_success'), 'data' => $create]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deleteAddOns(Request $request)
    {
        try {
            $addOnId = $request->id;
            $addOns = $this->product->findAddOnsById($addOnId);

            if ($addOns) {
                $delete = $this->product->deleteAddOns($addOnId);
                if ($delete)
                    return Response()->json([true, __('apps::vendor.general.message_delete_success')]);
                else
                    return Response()->json([false, __('apps::vendor.general.message_error')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deleteAddOnsOption(Request $request)
    {
        try {
            $addOnOptionId = $request->id;
            $addOnsOption = $this->product->findAddOnsOptionById($addOnOptionId);

            if ($addOnsOption) {
                $delete = $this->product->deleteAddOnsOption($addOnOptionId);
                if ($delete)
                    return Response()->json([true, __('apps::vendor.general.message_delete_success')]);
                else
                    return Response()->json([false, __('apps::vendor.general.message_error')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deleteProductImage(Request $request)
    {
        try {
            $id = $request->id;
            $prdImg = $this->product->findProductImgById($id);

            if ($prdImg) {
                $delete = $this->product->deleteProductImg($id);
                if ($delete)
                    return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
                else
                    return Response()->json([false, __('apps::dashboard.general.message_error')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
