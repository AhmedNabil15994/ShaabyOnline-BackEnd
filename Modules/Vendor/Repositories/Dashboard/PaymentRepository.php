<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Modules\Vendor\Entities\Payment;
use Hash;
use DB;

class PaymentRepository
{

    function __construct(Payment $payment)
    {
        $this->payment   = $payment;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $payments = $this->payment->orderBy($order, $sort)->get();
        return $payments;
    }

    public function findById($id)
    {
        $payment = $this->payment->find($id);
        return $payment;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $payment = $this->payment->create([
            'image'   => path_without_domain($request->image),
            'code'    => $request->code,
            "title"   => $request->title,
          ]);

       

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $payment = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($payment) : null;

        try {

            $payment->update([
              'image'   => $request->image ? path_without_domain($request->image) : $payment->image,
              'code'    => $request->code,
              "title"   => $request->title,
            ]);

         
            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->payment->where(function($query) use($request){

                        $query->where('id'          , 'like' , '%'. $request->input('search.value') .'%');
                        $query->where('code'        , 'like' , '%'. $request->input('search.value') .'%');

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
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();


        return $query;
    }

}
