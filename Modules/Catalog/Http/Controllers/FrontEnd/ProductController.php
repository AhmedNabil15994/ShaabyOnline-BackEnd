<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Catalog\Traits\CatalogTrait;

class ProductController extends Controller
{
    use CatalogTrait;

    protected $product;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request, $slug, $category = null)
    {
        $product = $this->product->findBySlug($slug);
        if (!$product)
            abort(404);

        if ($product && !checkRouteLocale($product, $slug)) {
            return redirect()->route('frontend.products.index', [
                $product->slug
            ]);
        }

        $variantPrd = null;
        $selectedOptions = [];
        $selectedOptionsValue = [];

        if (count($request->query()) > 0) {
            $selectedOptions = getOptionsAndValuesIds($request)['selectedOptions'];
            $selectedOptionsValue = getOptionsAndValuesIds($request)['selectedOptionsValue'];
            if ($request->has('var') && !empty($request->var) && !in_array("", $selectedOptions) && !in_array("", $selectedOptionsValue)) {
                $variantPrd = $this->product->findVariantProductById($request->var);
                $variantPrd->image = $variantPrd->image ? url($variantPrd->image) : null;
            }
        }

        $related_products = $this->product->getRelatedProducts($product, $product->categories->pluck('id')->toArray(), ["tags", "variants"]);
        return view('catalog::frontend.products.index', compact(
            'product',
            'related_products',
            'variantPrd',
            'selectedOptions',
            'selectedOptionsValue'
        ));
    }

    public function getPrdVariationInfo(Request $request)
    {
        $variantObject = [];
        $product = $this->product->findById($request->product_id);

        if (!$product)
            return response()->json(["errors" => __('catalog::frontend.products.product_not_found')], 422);

        if (count($request->selectedOptions) > 0 && count($request->selectedOptionsValue) > 0 && !in_array("", $request->selectedOptionsValue)) {

            $variantProducts = $this->product->getVariantProductsByPrdId($request->product_id);
            foreach ($variantProducts as $k => $val) {
                $values = $val->productValues()->pluck('option_value_id')->toArray();
                $result = array_diff($values, $request->selectedOptionsValue);
                if (count($result) == 0) {
                    $variantObject = $val;
                    $variantObject->image = $val->image ? url($val->image) : null;
                }
            }
        }

        if (!empty($variantObject)) {
            $data = [
                'variantProduct' => $variantObject,
                'form_view' => view('catalog::frontend.products._variant_add_to_cart_form')->with([
                    'product' => $product,
                    'variantProduct' => $variantObject,
                    'selectedOptions' => $request->selectedOptions,
                    'selectedOptionsValue' => $request->selectedOptionsValue,
                ])->render(),
            ];
            return response()->json(["message" => 'Success', "data" => $data], 200);
        } else {
            return response()->json(["errors" => __('catalog::frontend.products.validation.variation_not_found')], 422);
        }
    }
}
