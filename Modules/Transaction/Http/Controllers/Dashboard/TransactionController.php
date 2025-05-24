<?php

namespace Modules\Transaction\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Transaction\Transformers\Dashboard\TransactionResource;
use Modules\Transaction\Repositories\Dashboard\TransactionRepository as Transaction;

class TransactionController extends Controller
{

    function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function index()
    {
        return view('transaction::dashboard.transactions.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->transaction->QueryTable($request));

        $datatable['data'] = TransactionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        abort(404);
        return view('transaction::dashboard.transactions.show');
    }
}
