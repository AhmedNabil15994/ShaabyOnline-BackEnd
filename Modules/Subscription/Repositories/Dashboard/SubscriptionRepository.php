<?php

namespace Modules\Subscription\Repositories\Dashboard;

use Modules\Subscription\Entities\SubscriptionHistory;
use Modules\Subscription\Traits\SubscribeTrait;
use Modules\Subscription\Entities\Subscription;
use DB;

class SubscriptionRepository
{
    use SubscribeTrait;

    function __construct(Subscription $subscription,SubscriptionHistory $history)
    {
        $this->history        = $history;
        $this->subscription   = $subscription;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $subscriptions = $this->subscription->orderBy($order, $sort)->get();
        return $subscriptions;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $subscriptions = $this->subscription->active()->orderBy($order, $sort)->get();
        return $subscriptions;
    }

    public function findById($id)
    {
        $subscription = $this->subscription->withDeleted()->find($id);
        return $subscription;
    }

    public function create($request,$package)
    {
        DB::beginTransaction();

        try {

          $vendorSubscribed = $this->subscription->where('vendor_id',$request['vendor_id'])->unexpired()->started()->first();

          $details = $this->subscriptionDetails($package,$vendorSubscribed);

          $subscription = $this->subscription->updateOrCreate(
            [
              'vendor_id' => $request['vendor_id']
            ],
            [
            'status'           => $request['status'] ? 1 : 0,
            'package_id'       => $package['id'],
            'vendor_id'        => $request['vendor_id'],
            'original_price'   => $details['original_price'],
            'total'            => $details['total'],
            'start_at'         => $details['start_at'],
            'end_at'           => $details['end_at'],
          ]);

          // $subscription->transactions()->create([
          //   'method' => 'Manual',
          //   'data'   => $subscription,
          // ]);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }


    public function createHistory($request,$package)
    {
        DB::beginTransaction();

        try {

          $vendorSubscribed = $this->subscription->where('vendor_id',$request['vendor_id'])->unexpired()->started()->first();

          $details = $this->subscriptionDetails($package,$vendorSubscribed);

          $history = $this->history->create([
            'status'           => $request['status'] ? 1 : 0,
            'package_id'       => $package['id'],
            'vendor_id'        => $request['vendor_id'],
            'total'            => $details['total'],
            'start_at'         => $details['start_at'],
            'end_at'           => $details['end_at'],
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

        $subscription = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($subscription) : null;

        try {

            $subscription->update([
              'total'           => $request->total,
              'end_at'          => $request->end_at,
              'status'          => $request->status ? 1 : 0,
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
        $query = $this->subscription
                 ->with([
                     'vendor' => function ($query) {
                        $query->withDeleted();
                     },
                     'package' => function ($query) {
                       $query->withDeleted();
                     }
                 ])->where(function($query) use($request){
                      $query->where('id' , 'like' , '%'. $request->input('search.value') .'%');
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
