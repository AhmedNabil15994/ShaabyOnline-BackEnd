<?php

namespace Modules\Company\Repositories\Dashboard;

use Modules\Company\Entities\Company;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\SyncRelationModel;
use Illuminate\Support\Facades\File;
use Modules\Core\Traits\CoreTrait;

class CompanyRepository
{
    use SyncRelationModel, CoreTrait;

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getAllCount()
    {
        return $this->company->count();
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $companies = $this->company->orderBy($order, $sort)->get();
        return $companies;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $companies = $this->company->orderBy($order, $sort)->active()->get();
        return $companies;
    }

    public function findById($id)
    {
        $company = $this->company->withDeleted()/* ->with('availabilities') */->find($id);
        return $company;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'manager_name' => $request->manager_name ?? null,
                'email' => $request->email ?? null,
                'password' => $request->password ?? null,
                'calling_code' => $request->calling_code ?? null,
                'mobile' => $request->mobile ?? null,
                "name" => $request->name,
                "description" => $request->description,
                "delivery_time_types" => $request->delivery_time_types ?? null,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.company_img_path')), $request->image);
                $data['image'] = config('core.config.company_img_path') . '/' . $imgName;
            } else {
                $data['image'] = null;
            }

            if ($request->delivery_time_types && in_array('direct', $request->delivery_time_types ?? [])) {
                $data['direct_delivery_message'] = $request->direct_delivery_message ?? null;
            } else {
                $data['direct_delivery_message'] = null;
            }

            $company = $this->company->create($data);

            // START Add Work Times Over Weeks

            /* if (isset($request->days_status) && !empty($request->days_status)) {
                foreach ($request->days_status as $k => $dayCode) {
                    if (array_key_exists($dayCode, $request->is_full_day)) {
                        if ($request->is_full_day[$dayCode] == '1') {
                            $company->availabilities()->create([
                                'day_code' => $dayCode,
                                'status' => true,
                                'is_full_day' => true,
                            ]);
                        } else {
                            $availability = [
                                'day_code' => $dayCode,
                                'status' => true,
                                'is_full_day' => false,
                            ];

                            foreach ($request->availability['time_from'][$dayCode] as $key => $time) {
                                $availability['custom_times'][] = [
                                    'time_from' => $time,
                                    'time_to' => $request->availability['time_to'][$dayCode][$key],
                                ];
                            }

                            $company->availabilities()->create($availability);
                        }
                    }
                }
            } */

            // END Add Work Times Over Weeks

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
        $company = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($company) : null;

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'manager_name' => $request->manager_name ?? null,
                'email' => $request->email ?? null,
                'password' => $request->password ?? null,
                'calling_code' => $request->calling_code ?? null,
                'mobile' => $request->mobile ?? null,
                "name" => $request->name,
                "description" => $request->description,
                "delivery_time_types" => $request->delivery_time_types ?? null,
            ];

            if ($request->image) {
                if (!empty($company->image) && !in_array($company->image, config('core.config.special_images'))) {
                    File::delete($company->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.company_img_path')), $request->image);
                $data['image'] = config('core.config.company_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $company->image;
            }

            if ($request->delivery_time_types && in_array('direct', $request->delivery_time_types ?? [])) {
                $data['direct_delivery_message'] = $request->direct_delivery_message ?? null;
            } else {
                $data['direct_delivery_message'] = null;
            }

            $company->update($data);

            // START Edit Work Times Over Weeks

            /* if (isset($request->days_status) && !empty($request->days_status)) {
                $deletedProducts = $this->syncRelationModel($company, 'availabilities', 'day_code', $request->days_status);
            }

            if (isset($request->days_status) && !empty($request->days_status)) {
                foreach ($request->days_status as $k => $dayCode) {
                    if (array_key_exists($dayCode, $request->is_full_day)) {
                        if ($request->is_full_day[$dayCode] == '1') {
                            $availabilityArray = [
                                'day_code' => $dayCode,
                                'status' => true,
                                'is_full_day' => true,
                                'custom_times' => null,
                            ];

                            $company->availabilities()->updateOrCreate(['day_code' => $dayCode], $availabilityArray);
                        } else {
                            $availability = [
                                'day_code' => $dayCode,
                                'status' => true,
                                'is_full_day' => false,
                            ];

                            foreach ($request->availability['time_from'][$dayCode] as $key => $time) {
                                $availability['custom_times'][] = [
                                    'time_from' => $time,
                                    'time_to' => $request->availability['time_to'][$dayCode][$key],
                                ];
                            }

                            $company->availabilities()->updateOrCreate(['day_code' => $dayCode], $availability);
                        }
                    }
                }

                if (!empty($deletedProducts['deleted'])) {
                    $company->availabilities()->whereIn('day_code', $deletedProducts['deleted'])->delete();
                }
            } */

            // END Edit Work Times Over Weeks

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        return $model->restore();
    }



    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);
            if ($model) {
                if (!empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                    File::delete($model->image); ### Delete old image
                }
                if ($model->trashed()) :
                    $model->forceDelete();
                else :
                    $model->delete();
                endif;
            }

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

    public function QueryTable($request, $withCount = [])
    {
        $query = $this->company->with(['deliveryCharge']);
        $query->withCount($withCount);

        $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->where('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
        });

        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        // Search Categories by Created Dates
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

    public function syncRelationModel($model, $relation, $columnName = 'id', $arrayValues = null)
    {
        $oldIds = $model->$relation->pluck($columnName)->toArray();

        $data['deleted'] = array_values(array_diff($oldIds, $arrayValues));

        $data['updated'] = array_values(array_intersect($oldIds, $arrayValues));

        return $data;
    }
}
