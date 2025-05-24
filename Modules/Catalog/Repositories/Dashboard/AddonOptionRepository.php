<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Catalog\Entities\AddonOption;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\ProductAddon;
use Modules\Core\Traits\CoreTrait;
use function foo\func;

class AddonOptionRepository
{
    use CoreTrait;

    protected $addonOption;
    protected $addon;

    public function __construct(AddonOption $addonOption, ProductAddon $addon)
    {
        $this->addonOption = $addonOption;
        $this->addon = $addon;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->addonOption->orderBy($order, $sort)->get();
    }

    public function getAddonOptionsByCategory($addonCategoryId, $order = 'id', $sort = 'desc')
    {
        return $this->addonOption->where('addon_category_id', $addonCategoryId)->orderBy($order, $sort)->get();
    }

    public function checkProductAddonByProductAndCategory($productId, $addonCategoryId)
    {
        return $this->addon->where('product_id', $productId)->where('addon_category_id', $addonCategoryId)->first();
    }

    public function getAddonDetails($productAddonId)
    {
        return $this->addon->with(['addonOptions' => function ($query) {
            $query->with('addonOption');
        }])->find($productAddonId);
    }

    public function findById($id)
    {
        return $this->addonOption->withDeleted()->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'addon_category_id' => $request->addon_category_id ?? null,
                // 'image' => $request->image ? path_without_domain($request->image) : url(config('setting.images.logo')),
                'price' => $request->price,
                "title" => $request->title,
            ];

            if ($request->manage_qty == 'limited')
                $data['qty'] = $request->qty;
            else
                $data['qty'] = null;

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.addon_img_path')), $request->image);
                $data['image'] = config('core.config.addon_img_path') . '/' . $imgName;
            }

            $addonOption = $this->addonOption->create($data);

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

        $addonOption = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($addonOption) : null;

        try {
            $data = [
                'addon_category_id' => $request->addon_category_id ?? null,
                // 'image' => $request->image ? path_without_domain($request->image) : $addonOption->image,
                'price' => $request->price,
                "title" => $request->title,
            ];

            if ($request->manage_qty == 'limited')
                $data['qty'] = $request->qty;
            else
                $data['qty'] = null;

            if ($request->image) {
                if (!empty($addonOption->image) && !in_array($addonOption->image, config('core.config.special_images'))) {
                    File::delete($addonOption->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.addon_img_path')), $request->image);
                $data['image'] = config('core.config.addon_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $addonOption->image ?? null;
            }

            $addonOption->update($data);

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
            if ($model && !empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                File::delete($model->image); ### Delete old image
            }

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

    public function QueryTable($request)
    {
        $query = $this->addonOption->with('addonCategory')
            ->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhereHas('addonCategory', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                });
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

        if (isset($request['req']['addon_category_id']) && !empty($request['req']['addon_category_id'])) {
            $query->whereHas('addonCategory', function ($query) use ($request) {
                $query->where('id', $request['req']['addon_category_id']);
            });
        }

        return $query;
    }
}
