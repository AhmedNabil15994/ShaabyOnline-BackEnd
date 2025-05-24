<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Apps\Http\Requests\Dashboard\AppHomeRequest;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class AppHomeController extends Controller
{
    use CrudDashboardController{
        __construct as CrudConstruct;
    }

    public function __construct()
    {
        $this->CrudConstruct();
        $this->setRequest(AppHomeRequest::class);
    }
}
