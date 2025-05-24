<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Vendor\Entities\VendorStatus;

class VendorStatusRepository
{
    protected $vendorStatus;

    public function __construct(VendorStatus $vendorStatus)
    {
        $this->vendorStatus = $vendorStatus;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $vendor_status = $this->vendorStatus->orderBy($order, $sort)->get();
        return $vendor_status;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $vendor_status = $this->vendorStatus->active()->orderBy($order, $sort)->get();
        return $vendor_status;
    }

    public function findById($id)
    {
        $vendor_status = $this->vendorStatus->find($id);
        return $vendor_status;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $vendor_status = $this->vendorStatus->create([
                'accepted_orders' => $request->accepted_orders ? 1 : 0,
                'label_color' => $request->label_color,
                "title" => $request->title,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $vendor_status = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($vendor_status) : null;

        try {

            $vendor_status->update([
                'accepted_orders' => $request->accepted_orders ? 1 : 0,
                'label_color' => $request->label_color,
                "title" => $request->title,

            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
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

        } catch (\Exception $e) {
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

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->vendorStatus->where(function ($query) use ($request) {

            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Pages by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }

}
