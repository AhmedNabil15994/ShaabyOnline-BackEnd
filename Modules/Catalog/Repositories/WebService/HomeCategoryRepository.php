<?php

namespace Modules\Catalog\Repositories\WebService;

use Modules\Catalog\Entities\HomeCategory as Model;

class HomeCategoryRepository
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id, $with = [])
    {
        return $this->model
            ->with($with)
            ->active()->where("id", $id)->firstOrFail();
    }

    public function list($request, $with = [], $sort = "sort", $type = "asc")
    {
        $base = $this->model
            ->has('products')
            ->with($with)
            ->orderBy($sort, $type)
            ->active();

        if ($request->pagination) {
            return $base->paginate(is_numeric($request->pagination) ? $request->pagination : 10);
        }
        return $base->get();
    }
}
