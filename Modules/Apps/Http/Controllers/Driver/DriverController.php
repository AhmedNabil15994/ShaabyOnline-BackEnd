<?php

namespace Modules\Apps\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DriverController extends Controller
{
    public function index()
    {
        return view('apps::driver.index');
    }
}
