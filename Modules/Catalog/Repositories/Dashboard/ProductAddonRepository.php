<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Carbon\Carbon;
use Modules\Catalog\Entities\AddonCategory;
use Modules\Catalog\Entities\AddonOption;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductAddon;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\ProductAddonOption;
use Modules\Core\Traits\CoreTrait;
use Modules\Core\Traits\SyncRelationModel;

class ProductAddonRepository
{
    use SyncRelationModel, CoreTrait;

    protected $product;
    protected $addOn;
    protected $addOnOption;
    protected $addonCategory;

    public function __construct(Product $product, ProductAddon $addOn, AddonOption $addOnOption, AddonCategory $addonCategory)
    {
        $this->product = $product;
        $this->addOn = $addOn;
        $this->addOnOption = $addOnOption;
        $this->addonCategory = $addonCategory;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->addOn->orderBy($order, $sort)->get();
    }

    public function getAllByProductId($productId, $order = 'id', $sort = 'desc')
    {
        return $this->addOn->where('product_id', $productId)->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        return $this->product->withDeleted()->with(['tags', 'images', 'addOns'])->find($id);
    }

    public function findAddOnsById($id)
    {
        return $this->addOn->find($id);
    }

    public function findAddonCategoryById($id)
    {
        return $this->addonCategory->with('productAddons')->find($id);
    }

    public function findAddOnsOptionById($id)
    {
        return $this->addOnOption->find($id);
    }

    public function deleteAddOns($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findAddOnsById($id);

            if ($model) {
                $model->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteAddOnsOption($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findAddOnsOptionById($id);

            if ($model) {
                $model->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createAddOns($request, $id)
    {
        DB::beginTransaction();

        try {
            $product = $this->findById($id);
            if ($product) {

                if ($request->add_ons_type == 'multi') {
                    $data = [
                        'type' => 'multi',
                        'min_options_count' => $request->min_options_count ?? null,
                        'max_options_count' => $request->max_options_count ?? null,
                    ];
                } else {
                    $data = [
                        'type' => 'single',
                        'min_options_count' => null,
                        'max_options_count' => null,
                    ];
                }

                $data['is_required'] = !is_null($request->is_required);
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();

                $productAddon = $product->addOns()->updateOrCreate(['addon_category_id' => $request->addon_category_id], $data);

                $inputValuesForm = array_values(array_map('intval', $request->addon_options ?? []));
                $oldIds = $productAddon->addonOptions->pluck('addon_option_id')->toArray() ?? [];
                $deletedItems = array_values(array_diff($oldIds, $inputValuesForm));
                if (!empty($deletedItems))
                    ProductAddonOption::where('product_addon_id', $productAddon->id)->whereIn('addon_option_id', $deletedItems)->delete();

                if (!empty($request->addon_options)) {
                    foreach ($request->addon_options as $k => $option) {
                        $productAddon->addonOptions()->updateOrCreate(['addon_option_id' => $option], [
                            'default' => $option == $request->default ? 1 : 0,
                        ]);
                    }
                }

                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
