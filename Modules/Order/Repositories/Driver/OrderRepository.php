<?php

namespace Modules\Order\Repositories\Driver;

use Modules\Order\Entities\Order;
use Auth;
use DB;

class OrderRepository
{
    function __construct(Order $order)
    {
        $this->order   = $order;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order
                  ->whereHas('driver', function($q) {
                    $q->where('user_id', auth()->user()->id);
                  })->orderBy($order, $sort)->get();

        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order
                 ->with([
                  'orderProducts.product',
                  'orderProducts.orderVariant.orderVariantValues.variantValue.optionValue.option'
                 ])->whereHas('driver', function($q) {
                   $q->where('user_id', auth()->user()->id);
                 })->withDeleted()->find($id);

        return $order;
    }

    public function QueryTable($request)
    {
        $query = $this->order->whereHas('driver', function($q) {
                    $q->where('user_id', auth()->user()->id);
                 })->where(function($query) use($request){
                    $query->where('id' , 'like' , '%'. $request->input('search.value') .'%');
                 });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}
