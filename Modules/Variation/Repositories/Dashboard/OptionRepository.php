<?php

namespace Modules\Variation\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Variation\Entities\Option;
use Modules\Variation\Entities\OptionValue;

class OptionRepository
{
    protected $value;
    protected $option;

    public function __construct(Option $option, OptionValue $value)
    {
        $this->value = $value;
        $this->option = $option;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $options = $this->option->orderBy($order, $sort)->get();
        return $options;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $options = $this->option->with(['values' => function ($query) {
            $query->active();
        }])->whereHas('values', function ($query) {
            $query->active();
        })->active()->orderBy($order, $sort)->get();

        return $options;
    }

    public function getAllActiveHasValues($order = 'id', $sort = 'desc')
    {
        $options = $this->option->with(['values' => function ($query) {
            $query->active();
        }])->active()->orderBy($order, $sort)->get();
        return $options;
    }

    public function findByOptionId($optionId)
    {
        $values = $this->value->where('option_id', $optionId)->get();
        return $values;
    }

    public function findByOptionValuesId($optionIds)
    {
        $values = $this->value->whereIn('id', $optionIds)->get()->groupBy('option_id');
        return $values;
    }

    public function findOptionValueById($id, $with = [])
    {
        $option = $this->value->with($with)->find($id);
        return $option;
    }

    public function findById($id)
    {
        $option = $this->option->with(['values'])->withDeleted()->find($id);
        return $option;
    }

    public function checkIfHaveProductOptions($id)
    {
        $option = $this->option->with(['values'])->doesntHave('productOptions')->withDeleted()->find($id);
        return $option;
    }

    public function findBySlug($slug)
    {
        $option = $this->option->anyTranslation('slug', $slug)->first();

        return $option;
    }

    public function checkRouteLocale($model, $slug)
    {
        if ($array = $model->getTranslations("slug")) {
            $locale = array_search($slug, $array);

            return $locale == locale();
        }

        return true;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $option = $this->option->create([
                'status' => $request->status ? 1 : 0,
                "title" => $request->title,
                "notes" => $request->notes,
                'option_as_filter' => $request->option_as_filter ? 1 : 0,
                'is_color' => $request->is_color ? 1 : 0,
            ]);

            $this->createValues($option, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createValues($option, $request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['valueIndex'] as $key => $inputValue) {
                $dataTitleTrans = [];
                foreach (array_keys($request['option_value_title']) as $lang) {
                    $dataTitleTrans[$lang] = $request['option_value_title'][$lang][$key];
                }
                $optionValueStatus = $request->input("option_value_status.$key") ?? 0;
                $value = $option->values()->create([
                    'status' => $optionValueStatus,
                    "title" => $dataTitleTrans,
                ]);
            }

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

        $option = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($option) : null;

        try {
            $option->update([
                'status' => $request->status ? 1 : 0,
                'option_as_filter' => $request->option_as_filter ? 1 : 0,
                "title" => $request->title,
                "notes" => $request->notes,
                'is_color' => $request->is_color ? 1 : 0,
            ]);

            $this->updateValues($option, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateValues($option, $request)
    {
        DB::beginTransaction();

        $option->values()->whereNotIn('id', array_values($request['option_values_ids']))->delete();

        try {

            foreach ($request['valueIndex'] as $key => $inputValue) {
                $dataTitleTrans = [];

                $optionValueStatus = $request->input("option_value_status.$key") ?? 0;

                foreach (array_keys($request['option_value_title']) as $lang) {
                    $dataTitleTrans[$lang] = $request['option_value_title'][$lang][$key];
                }

                if (isset($request['option_values_ids'][$key])) {
                    $value = $option->values()->where('id', $request['option_values_ids'][$key])->updateOrCreate([
                        "option_id" => $option->id,
                        'id' => $request['option_values_ids'][$key],
                    ], ['status' => $optionValueStatus, "title" => $dataTitleTrans, 'value' => $request['value'][$key] ?? null]);
                } else {
                    $value = $option->values()->create([
                        'status' => $optionValueStatus,
                        "title" => $dataTitleTrans,
                        'value' => $request['value'][$key] ?? null,
                    ]);
                }
            }

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
                if (!is_null($this->checkIfHaveProductOptions($id))) {
                    $model = $this->delete($id);
                }
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
        $query = $this->option->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Options by Created Dates
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

    public function checkIfHaveOptionValueInVariantProduct($id)
    {
        return $this->value->has('productVariantValues')->find($id);
    }
}
