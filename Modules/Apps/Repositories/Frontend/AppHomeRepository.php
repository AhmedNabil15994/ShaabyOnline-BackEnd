<?php

namespace Modules\Apps\Repositories\Frontend;


use Illuminate\Http\Request;
use Modules\Apps\Entities\AppHome;

class AppHomeRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new AppHome();
    }

    public function getPagination(Request $request, $paginate = 6, $order = 'order', $sort = 'asc')
    {
        return $this->model->active()->Published()->orderBy($order, $sort)->paginate($paginate, ['id', 'type', 'title', 'description', 'display_type', 'grid_columns_count']);
    }

    public function getAll(Request $request, $order = 'order', $sort = 'asc')
    {
        return $this->model->active()->Published()->orderBy($order, $sort)->get(['id', 'type', 'title', 'description', 'display_type', 'grid_columns_count']);
    }
}
