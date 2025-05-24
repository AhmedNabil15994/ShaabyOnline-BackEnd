<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Product;
use Modules\Core\Traits\CoreTrait;
use Modules\Vendor\Entities\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class VendorRepository
{
    use CoreTrait;

    protected $vendor;
    protected $product;
    protected $prodCategory;
    protected $imgPath;

    function __construct(Vendor $vendor, Product $product, Category $prodCategory)
    {
        $this->vendor = $vendor;
        $this->product = $product;
        $this->prodCategory = $prodCategory;
        $this->imgPath = public_path('uploads/vendors');
    }

    public function countVendors()
    {
        $vendors = $this->vendor->count();
        return $vendors;
    }

    public function countSubscriptionsVendors()
    {
        $query = $this->vendor->query();

        $query->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
            return $q->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        });

        return $query->count();
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $vendors = $this->vendor->orderBy($order, $sort)->get();
        return $vendors;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->vendor->active()->orderBy($order, $sort)->get();
    }

    public function getAllActiveProdCategories($order = 'id', $sort = 'desc')
    {
        return $this->prodCategory->active()->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        $vendor = $this->vendor->withDeleted()->find($id);
        return $vendor;
    }

    public function getActiveVendorsWithLimitProducts($minQty)
    {
        $query = $this->vendor->query();

        $query = $query->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
            return $q->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        });

        if (config('setting.other.is_multi_vendors') == 0) {
            $query = $query->where('id', config('setting.default_vendor'));
        }

        $query = $query->active()->with(['products' => function ($q) use ($minQty) {
            $q->with('variants');
            $q->active();
            $q->where(function ($q) use ($minQty) {
                $q->where('qty', '<=', $minQty);
                $q->orWhereHas('variants', function ($q) use ($minQty) {
                    $q->where('qty', '<=', $minQty);
                });
            });
        }]);
        return $query->get();
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $data = [
                'vendor_status_id' => $request->vendor_status_id,
                'section_id' => $request->section_id ?? null,
                'vendor_email' => $request->vendor_email,
                /* 'supplier_code_myfatorah' => $request->supplier_code_myfatorah,
                'fixed_commission' => $request->fixed_commission,
                'commission' => $request->commission,
                'order_limit' => $request->order_limit,
                'is_trusted' => $request->is_trusted ? 1 : 0,
                'fixed_delivery' => $request->fixed_delivery, */
                // 'image' => path_without_domain($request->image),
                'status' => $request->status ? 1 : 0,
                'is_new' => $request->is_new ? 1 : 0,
                'use_app_drivers' => $request->use_app_drivers ? 1 : 0,
                "title" => $request->title,
                "description" => $request->description,
                "seo_description" => $request->seo_description,
                "seo_keywords" => $request->seo_keywords,
                'calling_code' => $request->calling_code ?? '965',
                'mobile' => $request->mobile ?? null,
                'address' => $request->address ?? null,
                'payment_data' => $request->payment_data ?? null,
                "delivery_time_types" => $request->delivery_time_types ?? null,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage($this->imgPath, $request->image);
                $data['image'] = 'uploads/vendors/' . $imgName;
            } else {
                $data['image'] = url(config('setting.images.logo'));
            }

            if ($request->delivery_time_types && in_array('direct', $request->delivery_time_types ?? [])) {
                $data['direct_delivery_message'] = $request->direct_delivery_message ?? null;
            } else {
                $data['direct_delivery_message'] = null;
            }

            $vendor = $this->vendor->create($data);

            if (!empty($request->seller_id)) {
                $sellerItems = $this->removeEmptyValuesFromArray($request->seller_id);
                $vendor->sellers()->sync($sellerItems);
            }

            if ($request->vendor_category_id)
                $vendor->categories()->sync(int_to_array($request->vendor_category_id));

            if (isset($request->days_status) && !empty($request->days_status) /* && config('setting.other.select_shipping_provider') == 'vendor_delivery' */) {
                $this->createWorkTimes($vendor, $request->days_status, $request->is_full_day, $request->availability);
            }

            /* if ($request->section_id) {
                $vendor->sections()->sync($request->section_id);
            } */

            /* if (isset($request->payment_id)) {
                $vendor->payments()->sync($request->payment_id);
            }

            if ($request->companies) {
                $vendor->companies()->sync($request->companies);
            }

            if ($request->states) {
                $vendor->states()->sync($request->states);
            } */


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

        $vendor = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($vendor) : null;

        try {

            $data = [
                'vendor_status_id' => $request->vendor_status_id,
                'section_id' => $request->section_id ?? null,
                'vendor_email' => $request->vendor_email,
                /* 'supplier_code_myfatorah' => $request->supplier_code_myfatorah,
                'fixed_commission' => $request->fixed_commission,
                'commission' => $request->commission,
                'order_limit' => $request->order_limit,
                'is_trusted' => $request->is_trusted ? 1 : 0,
                'fixed_delivery' => $request->fixed_delivery, */
                // 'image' => $request->image ? path_without_domain($request->image) : $vendor->image,
                'status' => $request->status ? 1 : 0,
                'is_new' => $request->is_new ? 1 : 0,
                'use_app_drivers' => $request->use_app_drivers ? 1 : 0,
                "title" => $request->title,
                "description" => $request->description,
                "seo_description" => $request->seo_description,
                "seo_keywords" => $request->seo_keywords,
                'calling_code' => $request->calling_code ?? '965',
                'mobile' => $request->mobile ?? null,
                'address' => $request->address ?? null,
                'payment_data' => $request->payment_data ?? null,
                "delivery_time_types" => $request->delivery_time_types ?? null,
            ];

            if ($request->image) {
                File::delete($vendor->image); ### Delete old image
                $imgName = $this->uploadImage($this->imgPath, $request->image);
                $data['image'] = 'uploads/vendors/' . $imgName;
            } else {
                $data['image'] = $vendor->image;
            }

            if ($request->delivery_time_types && in_array('direct', $request->delivery_time_types ?? [])) {
                $data['direct_delivery_message'] = $request->direct_delivery_message ?? null;
            } else {
                $data['direct_delivery_message'] = null;
            }

            $vendor->update($data);

            if (!empty($request->seller_id)) {
                $sellerItems = $this->removeEmptyValuesFromArray($request->seller_id);
                $vendor->sellers()->sync($sellerItems);
            } else {
                $vendor->sellers()->detach();
            }

            if ($request->vendor_category_id)
                $vendor->categories()->sync(int_to_array($request->vendor_category_id));

            if (isset($request->days_status) && !empty($request->days_status) /* && config('setting.other.select_shipping_provider') == 'vendor_delivery' */) {
                $this->updateWorkTimes($vendor, $request->days_status, $request->is_full_day, $request->availability);
            }

            /* if ($request->section_id) {
                $vendor->sections()->sync($request->section_id);
            } */

            /* if (isset($request->payment_id)) {
                $vendor->payments()->sync($request->payment_id);
            }

            if ($request->companies) {
                $vendor->companies()->sync($request->companies);
            }

            if ($request->states) {
                $vendor->states()->sync($request->states);
            } */

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function createWorkTimes($vendor, $days_status, $is_full_day, $availability)
    {
        // START Add Work Times Over Weeks
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '1') {
                    $vendor->workTimes()->create([
                        'day_code' => $dayCode,
                        'status' => true,
                        'is_full_day' => true,
                    ]);
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

                    $vendor->workTimes()->create($works);
                }
            }
        }
        return true;
        // END Add Work Times Over Weeks
    }

    private function updateWorkTimes($vendor, $days_status, $is_full_day, $availability)
    {
        // START Edit Work Times Over Weeks
        $deletedWorkTimes = $this->syncRelationModel($vendor, 'workTimes', 'day_code', $days_status);
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '1') {
                    $availabilityArray = [
                        'day_code' => $dayCode,
                        'status' => true,
                        'is_full_day' => true,
                        'custom_times' => null,
                    ];
                    $vendor->workTimes()->updateOrCreate(['day_code' => $dayCode], $availabilityArray);
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
                    $vendor->workTimes()->updateOrCreate(['day_code' => $dayCode], $works);
                }
            }
        }

        if (!empty($deletedWorkTimes['deleted'])) {
            $vendor->workTimes()->whereIn('day_code', $deletedWorkTimes['deleted'])->delete();
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

    public function updateInfo($request, $id)
    {
        DB::beginTransaction();

        $vendor = $this->findById($id);

        try {

            $vendor->update([
                'vendor_status_id' => $request->vendor_status_id,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateVendorStatus($request, $id)
    {
        DB::beginTransaction();
        $vendor = $this->findById($id);
        $status = filter_var($request->vendor_status_id, FILTER_VALIDATE_BOOLEAN);
        try {
            $vendor->update([
                'vendor_status_id' => $status == true ? 4 : null,
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function sorting($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['vendors'] as $key => $value) {

                $key++;

                $this->vendor->find($value)->update([
                    'sorting' => $key,
                ]);
            }

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
        return true;
    }



    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);
            if ($model)
                File::delete($model->image); ### Delete old image

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


    public function getAllPaginatedProducts($request, $order = 'id', $sort = 'desc', $count = 50)
    {
        $query = $this->product->orderBy($order, $sort)->active();

        if (isset($request->category) && !empty($request->category)) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('product_categories.category_id', $request->category);
            });
        }

        return $query->paginate($count);
    }

    public function assignVendorProducts($vendor, $request)
    {
        DB::beginTransaction();

        try {
            if (isset($request->ids) && !empty($request->ids)) {
                foreach ($request->ids as $k => $id) {
                    $pivotArray = ['price' => $request->price[$id], 'qty' => $request->qty[$id]];
                    if (isset($request->status[$id])) {
                        $pivotArray['status'] = isset($request->status[$id]) || $request->status[$id] == 'on' ? 1 : 0;
                    } else {
                        $pivotArray['status'] = 0;
                    }
                    $products_array[$id] = $pivotArray;
                }
                // sync without delete old items
                $vendor->products()->sync($products_array, false);
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
        $query = $this->vendor->with([]);

        $query->where(function ($query) use ($request) {

            $query
                ->where('id', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere(function ($query) use ($request) {
                    $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                });
        });

        return $this->filterDataTable($query, $request);
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

        if (isset($request['req']['sections']) && $request['req']['sections'] != '') {

            $query->where('section_id', $request['req']['sections']);

            /* $query->whereHas('sections', function ($query) use ($request) {
                $query->where('section_id', $request['req']['sections']);
            }); */
        }

        return $query;
    }
}
