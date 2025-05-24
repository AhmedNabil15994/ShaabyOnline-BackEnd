<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Modules\Vendor\Entities\Section;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\CoreTrait;

class SectionRepository
{
    use CoreTrait;

    protected $section;

    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /*
    * Frontend Queries
    */
    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $sections = $this->section->active()->orderBy($order, $sort)->get();
        return $sections;
    }

    public function getAllActiveWithVendors()
    {
        $sections = $this->section->whereHas('vendors', function ($query) {
            $query->active()->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        })->active()->inRandomOrder()->take(10)->get();

        return $sections;
    }

    public function findBySlug($slug)
    {
        $section = $this->section->whereHas('vendors', function ($query) {
            $query->active()->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        })->anyTranslation('slug', $slug)->first();

        return $section;
    }

    public function checkRouteLocale($model, $slug)
    {
        // if ($model->translate()->where('slug', $slug)->first()->locale != locale()) {
        //     return false;
        // }
        if ($array = $model->getTranslations("slug")) {
            $locale = array_search($slug, $array);

            return $locale == locale();
        }

        return true;
    }

    /*
    * Dashboard Queries
    */
    public function getAll($order = 'id', $sort = 'desc')
    {
        $sections = $this->section->orderBy($order, $sort)->get();
        return $sections;
    }

    public function findById($id)
    {
        $section = $this->section->withDeleted()->find($id);
        return $section;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $data = [
                'status' => $request->status ? 1 : 0,
                // 'image' => $request->image ? path_without_domain($request->image) : null,
                "description" => $request->description,
                "seo_description" => $request->seo_description,
                "seo_keywords" => $request->seo_keywords,
                "title" => $request->title,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.section_img_path')), $request->image);
                $data['image'] = config('core.config.section_img_path') . '/' . $imgName;
            } else {
                $data['image'] = null;
            }

            $section = $this->section->create($data);

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

        $section = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($section) : null;

        try {

            $data = [
                'status' => $request->status ? 1 : 0,
                // 'image' => $request->image ? path_without_domain($request->image) : $section->image,
                "description" => $request->description,
                "seo_description" => $request->seo_description,
                "seo_keywords" => $request->seo_keywords,
                "title" => $request->title,
            ];

            if ($request->image) {
                if (!empty($section->image) && !in_array($section->image, config('core.config.special_images'))) {
                    File::delete($section->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.section_img_path')), $request->image);
                $data['image'] = config('core.config.section_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $section->image;
            }

            $section->update($data);

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

    public function QueryTable($request)
    {
        $query = $this->section->query();

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
