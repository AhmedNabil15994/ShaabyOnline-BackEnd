<?php

namespace Modules\Catalog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Http\Requests\Dashboard\AddOnsRequest;
use Modules\Catalog\Repositories\Dashboard\ProductAddonRepository as ProductAddon;
use Modules\Catalog\Transformers\Dashboard\ProductAddonResource;

class ProductAddonsController extends Controller
{
    protected $product;
    protected $defaultVendor;

    function __construct(ProductAddon $product)
    {
        $this->product = $product;
        $this->defaultVendor = app('vendorObject') ?? null;
    }

    public function addOns($id)
    {
        if (config('setting.products.toggle_addons') != 1)
            abort(404);

        $product = $this->product->findById($id);
        if (!$product)
            abort(404);

        return view('catalog::dashboard.products.addons', compact('product'));
    }

    public function storeAddOns($id, AddOnsRequest $request)
    {
        try {
            $productAddon = $this->product->createAddOns($request, $id);
            if ($productAddon) {
                $productAddons = $this->product->getAllByProductId($id);
                return Response()->json([true, __('apps::dashboard.general.message_create_success'), 'data' => ProductAddonResource::collection($productAddons)]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
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
                    return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
                else
                    return Response()->json([false, __('apps::dashboard.general.message_error')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
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
