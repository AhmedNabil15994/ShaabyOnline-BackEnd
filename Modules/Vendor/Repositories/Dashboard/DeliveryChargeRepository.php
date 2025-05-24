<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Modules\Vendor\Entities\VendorDeliveryCharge;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DeliveryChargeRepository
{
    protected $deliveryCharge;

    function __construct(VendorDeliveryCharge $deliveryCharge)
    {
        $this->deliveryCharge = $deliveryCharge;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $deliveryCharges = $this->deliveryCharge->orderBy($order, $sort)->get();
        return $deliveryCharges;
    }

    public function findById($id)
    {
        $deliveryCharge = $this->deliveryCharge->find($id);
        return $deliveryCharge;
    }

    public function findDeliveryCharge($vendorId, $stateId)
    {
        $deliveryCharge = $this->deliveryCharge
            ->where('vendor_id', $vendorId)
            ->where('state_id', $stateId)
            ->first();

        return $deliveryCharge;
    }

    public function update($request, $vendor)
    {
        DB::beginTransaction();

        try {

            $vendor->deliveryCharge()->delete();

            foreach ($request['state'] as $key => $state) {
                if (isset($request['status'][$state]) && $request['status'][$state] == 'on') {
                    $vendor->deliveryCharge()->updateOrCreate([
                        'state_id' => $state,
                        'delivery' => $request['delivery'][$key] ?? null,
                        'delivery_time' => $request['delivery_time'][$state] ?? null,
                        'min_order_amount' => $request['min_order_amount'][$key] ?? null,
                        'status' => $request['status'][$state] == 'on' ? 1 : 0,
                    ]);
                }
            }

            if (isset($request->days_status) && !empty($request->days_status) && config('setting.other.select_shipping_provider') == 'vendor_delivery' && in_array('schedule', $vendor->delivery_time_types ?? [])) {
                $this->updateDeliveryTimes($vendor, $request->days_status, $request->is_full_day, $request->availability);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function updateDeliveryTimes($vendor, $days_status, $is_full_day, $availability)
    {
        // START Edit Work Times Over Weeks
        $deletedWorkTimes = $this->syncRelationModel($vendor, 'deliveryTimes', 'day_code', $days_status);
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '1') {
                    $availabilityArray = [
                        'day_code' => $dayCode,
                        'status' => true,
                        'is_full_day' => true,
                        'custom_times' => null,
                    ];
                    $vendor->deliveryTimes()->updateOrCreate(['day_code' => $dayCode], $availabilityArray);
                } else {
                    $works = [
                        'day_code' => $dayCode,
                        'status' => true,
                        'is_full_day' => false,
                    ];

                    foreach ($availability['time_from'][$dayCode] as $key => $time) {
                        $works['custom_times'][] = [
                            'time_from' => $time,
                            'time_to' => $availability['time_to'][$dayCode][$key],
                        ];
                    }
                    $vendor->deliveryTimes()->updateOrCreate(['day_code' => $dayCode], $works);
                }
            }
        }

        if (!empty($deletedWorkTimes['deleted'])) {
            $vendor->deliveryTimes()->whereIn('day_code', $deletedWorkTimes['deleted'])->delete();
        }
        return true;
        // END Edit Work Times Over Weeks
    }

    private function syncRelationModel($model, $relation, $columnName = 'id', $arrayValues = null)
    {
        $oldIds = $model->$relation->pluck($columnName)->toArray();
        $data['deleted'] = array_values(array_diff($oldIds, $arrayValues));
        $data['updated'] = array_values(array_intersect($oldIds, $arrayValues));
        return $data;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);
            $model->delete();

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
        $query = $this->deliveryCharge->where(function ($query) use ($request) {

            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('delivery', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Pages by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) && $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) && $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }
}
