<?php

namespace Modules\DeveloperTools\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('developertools::index');
    }
}
