<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Requests\Dashboard\GetExcelHeaderRowRequest;
use Modules\Apps\Imports\GetFirstRowImport;
use Modules\Core\Traits\Dashboard\ControllerResponse;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        return view('apps::dashboard.index');
    }

    public function getExcelHeaderRow(GetExcelHeaderRowRequest $request)
    {
        try {

            $rows = Excel::toArray(new GetFirstRowImport, $request->file('excel_file'));
            $excel_cols = $rows[0][0];
            $selectors = view(strtolower($request->module).'::dashboard.' . $request->view_path , compact('excel_cols'))->render();
            return response()->json([true,'ignore_success' => true , 'selectors' => $selectors]);

        } catch (\PDOException $e) {

            return $this->createError(null, [false, $e->errorInfo[2]]);
        }
    }
}
