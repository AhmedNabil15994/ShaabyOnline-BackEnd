<?php

namespace Modules\Variation\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Variation\Repositories\Dashboard\OptionRepository as Option;

class OptionController extends Controller
{
    protected $option;

    function __construct(Option $option)
    {
        $this->option = $option;
    }

    public function valuesByOptionId(Request $request)
    {
        $valuesGrouped = $this->option->findByOptionValuesId($request['values_ids']);

        $data = [];

        foreach ($valuesGrouped as $key => $optionValues) {
            $data[] = $optionValues->pluck('id');
        }

        $variations = combinations($data);
        $res = [];

        if ($request->current_option) {
            foreach ($variations as $key => $variation) {
                if (!in_array($variation, $request->current_option)) {
                    array_push($res, $variation);
                }
            }
        } else {
            $res = $variations;
        }

        return view('catalog::vendor.products.html.tabs_variation_blank', compact('res'));
    }
}
