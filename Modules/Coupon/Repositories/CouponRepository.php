<?php

namespace Modules\Coupon\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;

class CouponRepository
{
    protected $coupon;

    function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function findById($id)
    {
        $coupon = $this->coupon->with('vendors', 'users', 'categories', 'products')->withDeleted()->find($id);
        return $coupon;
    }

    /**
     * @throws \Exception
     */
    public function create($request)
    {

        DB::beginTransaction();

        try {
            $data = [
                'code' => $request->code <> null ? $request->code : str_random(5),
                'discount_type' => $request->discount_type ?? 'percentage',
                'max_discount_percentage_value' => $request->max_discount_percentage_value ?? null,
                'max_users' => $request->max_users,
                'user_max_uses' => $request->user_max_uses,
                'start_at' => $request->start_at,
                'expired_at' => $request->expired_at,
                'custom_type' => $request->custom_type,
                'status' => $request->status ? 1 : 0,
                'flag' => $request->coupon_flag ?? null,
                "title" => $request->title
            ];

            /* if ($request->discount_type == 'value') {
                $data['discount_percentage'] = null;
                $data['discount_value'] = $request->discount_value;
            } elseif ($request->discount_type == 'percentage') {
                $data['discount_percentage'] = $request->discount_percentage;
                $data['discount_value'] = null;
            } else {
                $data['discount_percentage'] = null;
                $data['discount_value'] = null;
            } */

            $data['discount_percentage'] = $request->discount_percentage ?? null;
            $data['discount_value'] = null;
            $coupon = $this->coupon->create($data);



            if ($request->coupon_flag == 'vendors' && $request['vendor_ids'])
                $this->vendorsOfCouponSync($coupon, $request);

            if ($request->coupon_flag == 'categories' && $request['category_ids'])
                $this->categoriesOfCouponSync($coupon, $request);

            if ($request->coupon_flag == 'products' && $request['product_ids'])
                $this->productsOfCouponSync($coupon, $request);

            if ($request['user_ids'])
                $this->usersOfCouponSync($coupon, $request);

            /*if ($request['vendor_ids'])
                $this->vendorsOfCouponSync($coupon, $request);
            if ($request['user_ids'])
                $this->usersOfCouponSync($coupon, $request);
            if ($request['category_ids'])
                $this->categoriesOfCouponSync($coupon, $request);
            if ($request['ipackage_ids'])
                $this->ipackagesOfCouponSync($coupon, $request);
            if ($request['product_ids'])
                $this->productsOfCouponSync($coupon, $request);*/

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

        $coupon = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($coupon) : null;

        try {
            $data = [
                'code' => $request->code,
                'discount_type' => $request->discount_type ?? 'percentage',
                'max_discount_percentage_value' => $request->max_discount_percentage_value ?? null,
                'max_users' => $request->max_users,
                'user_max_uses' => $request->user_max_uses,
                'start_at' => $request->start_at,
                'expired_at' => $request->expired_at,
                'custom_type' => $request->custom_type,
                'status' => $request->status ? 1 : 0,
                'flag' => $request->coupon_flag ?? null,
                "title" => $request->title
            ];

            /* if ($request->discount_type == 'value') {
                $data['discount_percentage'] = null;
                $data['discount_value'] = $request->discount_value;
            } elseif ($request->discount_type == 'percentage') {
                $data['discount_percentage'] = $request->discount_percentage;
                $data['discount_value'] = null;
            } else {
                $data['discount_percentage'] = null;
                $data['discount_value'] = null;
            } */

            $data['discount_percentage'] = $request->discount_percentage ?? null;
            $data['discount_value'] = null;
            $coupon->update($data);



            if ($request->coupon_flag == 'vendors') {
                $this->vendorsOfCouponSync($coupon, $request);
                $coupon->categories()->detach();
                $coupon->products()->detach();
            }

            if ($request->coupon_flag == 'categories') {
                $this->categoriesOfCouponSync($coupon, $request);
                $coupon->vendors()->detach();
                $coupon->products()->detach();
            }

            if ($request->coupon_flag == 'products') {
                $this->productsOfCouponSync($coupon, $request);
                $coupon->vendors()->detach();
                $coupon->categories()->detach();
            }

            $this->usersOfCouponSync($coupon, $request);

            /*if ($request['vendor_ids'])
                $this->vendorsOfCouponSync($coupon, $request);
            if ($request['user_ids'])
                $this->usersOfCouponSync($coupon, $request);
            if ($request['category_ids'])
                $this->categoriesOfCouponSync($coupon, $request);
            if ($request['ipackage_ids'])
                $this->ipackagesOfCouponSync($coupon, $request);
            if ($request['product_ids'])
                $this->productsOfCouponSync($coupon, $request);*/

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()) :
                $model->forceDelete();
            else :
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



    public function vendorsOfCouponSync($model, $request)
    {
        $model->vendors()->sync($request['vendor_ids']);
        return true;

        /*foreach ($request['vendor_ids'] as $key => $value) {
            $model->vendors()->updateOrCreate([
                'vendor_id' => $value,
            ]);
        }
        return true;*/
    }

    public function usersOfCouponSync($model, $request)
    {
        $model->users()->sync($request['user_ids']);
        return true;

        /*foreach ($request['user_ids'] as $key => $value) {
            $model->users()->updateOrCreate([
                'user_id' => $value,
            ]);
        }
        return true;*/
    }

    public function categoriesOfCouponSync($model, $request)
    {
        $model->categories()->sync($request['category_ids']);
        return true;

        /*foreach ($request['category_ids'] as $key => $value) {
            $model->categories()->updateOrCreate([
                'category_id' => $value,
            ]);
        }
        return true;*/
    }

    public function ipackagesOfCouponSync($model, $request)
    {
        foreach ($request['ipackage_ids'] as $key => $value) {
            $model->ipackages()->updateOrCreate([
                'ipackage_id' => $value,
            ]);
        }
        return true;
    }

    public function productsOfCouponSync($model, $request)
    {
        $model->products()->sync($request['product_ids']);
        return true;

        /*foreach ($request['product_ids'] as $key => $value) {
            $model->products()->updateOrCreate([
                'product_id' => $value,
            ]);
        }
        return true;*/
    }

    public function QueryTable($request)
    {
        $query = $this->coupon->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // SEARCHING INPUT DATATABLE
        if ($request->input('search.value') != null) {

            $query = $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            });
        }

        // FILTER
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
