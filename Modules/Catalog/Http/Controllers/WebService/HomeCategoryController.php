<?php

namespace Modules\Catalog\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Catalog\Transformers\WebService\ProductResource;
use Modules\Catalog\Transformers\WebService\HomeCategoryResource;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Catalog\Repositories\WebService\HomeCategoryRepository as Repo;

class HomeCategoryController extends WebServiceController
{
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        return $this->responsePagination(HomeCategoryResource::collection(
            $this->repo->list($request)
        ));
    }

    public function listProducts(Request $request){
        return $this->responsePagination(ProductResource::collection(
            $this->repo->listProducts($request)
        ));
    }
}
