<?php

namespace Modules\Transaction\Repositories\Dashboard;

use Modules\Transaction\Entities\Transaction;
use Hash;
use DB;

class TransactionRepository
{

    function __construct(Transaction $transaction)
    {
        $this->transaction   = $transaction;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $transactions = $this->transaction->orderBy($order, $sort)->get();
        return $transactions;
    }

    public function findById($id)
    {
        $transaction = $this->transaction->find($id);
        return $transaction;
    }

    public function QueryTable($request)
    {
        $query = $this->transaction->where(function($query) use($request){
                    $query->where('id'                 , 'like' , '%'. $request->input('search.value') .'%');
                 });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Pages by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query;

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}
