<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Facades\Schema;

trait DataTable
{
    // DataTable Methods
    public static function drawTable($request, $query, $table = '')
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data', 'id');
        $sort['dir'] = $request->input('order.0.dir', 'asc');
        $search = $request->input('search.value');

        $counter = $query->count();

        if (Schema::hasColumn($table, 'total')) {
            $output['recordsTotalSum'] = $query->sum('total');
            /* if ($table == 'orders') {

                $output['recordsUnconfirmedTotalSum'] = $query->sum('total', function($query){
                    $query = $query->whereHas('paymentStatus', function ($query) {
                        $query->whereIn('flag', ['pending', 'cash']);
                    });
                });

            }else{
                $output['recordsUnconfirmedTotalSum'] = 0;
            } */
        }

        $output['recordsTotal'] = $counter;
        $output['recordsFiltered'] = $counter;
        $output['draw'] = intval($request->input('draw'));
        $query_model = null;
        if (method_exists($query, 'getModel')) {
            $query_model = $query->getModel();
        }

        if ($query_model && method_exists($query_model, 'isTranslatableAttribute') && $query_model->isTranslatableAttribute($sort['col'])) {
            $sort["col"]   = $sort["col"] . "->" . locale();
        }

        // Get Data
        $models = $query
            ->orderBy($sort['col'], $sort['dir'])
            //            ->orderBy($order_by_translation_key ?? $sort['col'], $sort['dir'])
            ->skip($request->input('start'))
            ->take($request->input('length', 25))
            ->get();

        $output['data'] = $models;

        return $output;
    }
}
