<?php

namespace Modules\Area\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Transformers\WebService\CityResource;
use Modules\Area\Transformers\WebService\StateResource;
use Modules\Area\Repositories\Dashboard\AreaRepository as Area;

class AreaController extends Controller
{
    protected $area;

    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    public function getChildAreaByParent(Request $request)
    {
        $items = $this->area->getChildAreaByParent($request);
        if ($request->type == 'city') {
            $items = CityResource::collection($items);
        } elseif ($request->type == 'state') {
            $items = StateResource::collection($items);
        }
        return response()->json(['success' => true, 'data' => $items]);
    }
}
