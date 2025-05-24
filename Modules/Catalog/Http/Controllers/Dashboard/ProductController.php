<?php

namespace Modules\Catalog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Catalog\Http\Requests\Dashboard\ProductRequest;
use Modules\Catalog\Http\Requests\Dashboard\updatePhotoRequest;
use Modules\Catalog\Transformers\Dashboard\ProductResource;
use Modules\Catalog\Http\Requests\Dashboard\ImportProductRequest;
use Modules\Catalog\Http\Requests\Dashboard\ImportProductPhotoRequest;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;

class ProductController extends Controller
{
    protected $product;
    protected $defaultVendor;

    function __construct(Product $product)
    {
        $this->product = $product;
        $this->defaultVendor = app('vendorObject') ?? null;
    }

    public function index()
    {
        return view('catalog::dashboard.products.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->product->QueryTable($request));
        $datatable['data'] = ProductResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function reviewProducts()
    {
        if (!is_null($this->defaultVendor))
            return abort(404);

        return view('catalog::dashboard.products.review-products.index');
    }

    public function reviewProductsDatatable(Request $request)
    {
        if (!is_null($this->defaultVendor))
            return abort(404);

        $datatable = DataTable::drawTable($request, $this->product->reviewProductsQueryTable($request));
        $datatable['data'] = ProductResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('catalog::dashboard.products.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            $create = $this->product->create($request);

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
        return abort(404);

        /*$product = $this->product->getProductDetailsById($id);
        if (!$product)
            return abort(404);

        return view('catalog::dashboard.products.show', compact('product'));*/
    }

    public function edit($id)
    {
        $product = $this->product->findById($id);
        if (!$product)
            return abort(404);

        $product->load(["variantValues", "variants.productValues.optionValue.option", "categories"]);
        $currentVaration = $product->variantValues->sortBy("option_value_id")->groupBy("product_variant_id")->pluck("*.option_value_id")->toArray();

        return view('catalog::dashboard.products.edit', compact('product', "currentVaration"));
    }

    public function clone($id)
    {
        $product = $this->product->findById($id);
        if (!$product)
            return abort(404);

        $product->load(["variantValues", "variants.productValues.optionValue.option", "categories"]);
        $currentVaration = $product->variantValues->sortBy("option_value_id")->groupBy("product_variant_id")->pluck("*.option_value_id")->toArray();

        return view('catalog::dashboard.products.clone', compact('product', 'currentVaration'));
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $update = $this->product->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function updatePhoto(updatePhotoRequest $request)
    {
        try {
            $imagePath = $this->product->updatePhoto($request);

            if ($imagePath) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success'), 'imagePath' => $imagePath]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            throw $e;
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function Import(ImportProductRequest $request)
    {
        try {

            $this->product->import($request);
            
            return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function importPhoto(ImportProductPhotoRequest $request)
    {
        try {

            $this->product->importPhotos($request);
            return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function approveProduct(Request $request, $id)
    {
        try {
            $update = $this->product->approveProduct($request, $id);

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
            $delete = $this->product->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
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
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
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
