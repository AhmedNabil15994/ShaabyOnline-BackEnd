<?php

namespace Modules\Catalog\Repositories\Vendor;

use Illuminate\Support\Facades\File;
use Modules\Catalog\Entities\AddonOption;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\AddonCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\ProductImage;
use Modules\Catalog\Entities\SearchKeyword;
use Modules\Catalog\Enums\ProductFlag;
use Modules\Core\Traits\CoreTrait;
use Modules\Core\Traits\SyncRelationModel;

class ProductRepository
{
    use SyncRelationModel, CoreTrait;

    protected $product;
    protected $addOn;
    protected $addOnOption;
    protected $prdImg;
    protected $imgPath;

    public function __construct(Product $product, AddonCategory $addOn, AddonOption $addOnOption, ProductImage $prdImg)
    {
        $this->product = $product;
        $this->addOn = $addOn;
        $this->addOnOption = $addOnOption;
        $this->prdImg = $prdImg;
        $this->imgPath = public_path('uploads/products');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $products = $this->product->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->orderBy($order, $sort)->get();

        return $products;
    }

    public function findById($id)
    {
        $product = $this->product->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->with(['tags', 'images', 'addOns.addonOptions'])->find($id);

        return $product;
    }

    public function findAddOnsById($id)
    {
        return $this->addOn->with('addonOptions')->find($id);
    }

    public function findProductImgById($id)
    {
        return $this->prdImg->find($id);
    }

    public function findAddOnsOptionById($id)
    {
        return $this->addOnOption->find($id);
    }


    public function restoreSoftDelete($model)
    {
        $model->restore();
        return true;
    }

    public function translateAddOnTable($model, $request)
    {
        foreach ($request['option_name'] as $locale => $value) {
            $model->translateOrNew($locale)->name = $value;
        }

        $model->save();
    }

    public function translateAddOnOptionTable($model, $options)
    {
        foreach ($options as $locale => $value) {
            $model->translateOrNew($locale)->option = $value;
        }
        $model->save();
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'product_flag' => $request->product_flag ?? ProductFlag::Single,
                'featured' => $request->featured == 'on' ? 1 : 0,
                'status' => $request->status == 'on' ? 1 : 0,
                'is_new' => $request->is_new == 'on' ? 1 : 0,
                'sku' => $request->sku,
                'title' => $request->title,
                'short_description' => $request->short_description ?? null,
                'description' => $request->description,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage($this->imgPath, $request->image);
                $data['image'] = 'uploads/products/' . $imgName;
            } else {
                $data['image'] = url(config('setting.images.logo'));
            }

            if (config('setting.other.is_multi_vendors') == 1) {
                $data['vendor_id'] = $request->vendor_id;
            } else {
                $data['vendor_id'] = config('setting.default_vendor') ?? null;
            }

            if (auth()->user()->can('pending_products_for_approval')) {
                $data['pending_for_approval'] = 1;
            }

            if ($request->product_flag == ProductFlag::Single) {
                $data['price'] = $request->price;
                if ($request->manage_qty == 'limited') {
                    $data['qty'] = $request->qty;
                } else {
                    $data['qty'] = null;
                }
                $data["shipment"] = $request->shipment;
            } else {
                $data['price'] = null;
                $data['qty'] = null;
                $data["shipment"] = null;
            }

            $product = $this->product->create($data);

            $product->categories()->sync(int_to_array($request->category_id));

            if ($request->offer_status != "on" && $request->product_flag == ProductFlag::Variant) {
                $this->productVariants($product, $request);
            } else {
                $this->productOffer($product, $request);
            }

            $this->createProductGallery($product, $request->images);
            $this->saveProductTags($product, $request->tags);
            $this->saveProductKeywords($product, $request->search_keywords);
            // $this->saveHomeCategories($product, $request->home_categories);

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
        $product = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($product) : null;

        if (isset($request->images) && !empty($request->images)) {
            $sync = $this->syncRelation($product, 'images', $request->images);
        }

        try {
            $data = [
                'product_flag' => $request->product_flag ?? ProductFlag::Single,
                'featured' => $request->featured == 'on' ? 1 : 0,
                'status' => $request->status == 'on' ? 1 : 0,
                'is_new' => $request->is_new == 'on' ? 1 : 0,
                'sku' => $request->sku,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords,
            ];

            if (config('setting.other.is_multi_vendors') == 1) {
                $data['vendor_id'] = $request->vendor_id;
            } else {
                $data['vendor_id'] = config('setting.default_vendor') ?? null;
            }

            if ($request->product_flag == ProductFlag::Single) {
                if (auth()->user()->can('edit_products_price')) {
                    $data['price'] = $request->price;
                }

                if (auth()->user()->can('edit_products_qty')) {
                    if ($request->manage_qty == 'limited') {
                        $data['qty'] = $request->qty;
                    } else {
                        $data['qty'] = null;
                    }
                }

                $data["shipment"] = $request->shipment;
            } else {
                $data['price'] = null;
                $data['qty'] = null;
                $data["shipment"] = null;
            }

            if (auth()->user()->can('edit_products_image')) {
                if ($request->image) {
                    File::delete($product->image); ### Delete old image
                    $imgName = $this->uploadImage($this->imgPath, $request->image);
                    $data['image'] = 'uploads/products/' . $imgName;
                } else {
                    $data['image'] = $product->image;
                }
            }

            if (auth()->user()->can('pending_products_for_approval')) {
                $data['pending_for_approval'] = 1;
            }

            if (auth()->user()->can('edit_products_title')) {
                $data["title"] = $request->title;
            }

            if (auth()->user()->can('edit_products_description')) {
                $data["description"] = $request->description;
                $data["short_description"] = $request->short_description ?? null;
            }

            $product->update($data);

            if (auth()->user()->can('edit_products_category')) {
                $product->categories()->sync(int_to_array($request->category_id));
            }

            if ($request->product_flag == ProductFlag::Single) {
                if ($request->offer_status == "on") {
                    if (auth()->user()->can('edit_products_price')) {
                        $this->productOffer($product, $request);
                    }
                }
                $product->variants()->delete();
            } else {
                $this->productVariants($product, $request);
                $product->offer()->delete();
            }

            if (auth()->user()->can('edit_products_gallery')) {
                if (isset($request->images) && !empty($request->images)) {
                    $this->updateProductGallery($product, $request->images, $sync['updated']);
                }
            }

            $this->saveProductTags($product, $request->tags);
            $this->saveProductKeywords($product, $request->search_keywords);
            // $this->saveHomeCategories($product, $request->home_categories);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function createProductGallery($model, $images)
    {
        if (isset($images) && !empty($images)) {
            $imgPath = public_path('uploads/products');
            foreach ($images as $k => $img) {
                $imgName = $img->hashName();
                $img->move($imgPath, $imgName);

                $model->images()->create([
                    'image' => $imgName,
                ]);
            }
        }
    }

    private function updateProductGallery($model, $images, $syncUpdated = [])
    {
        if (!empty($images)) {
            $imgPath = public_path('uploads/products');

            // Update Old Images
            if (!empty($syncUpdated)) {
                foreach ($syncUpdated as $k => $id) {
                    $oldImgObj = $model->images()->find($id);
                    File::delete('uploads/products/' . $oldImgObj->image); ### Delete old image

                    $img = $images[$id];
                    $imgName = $img->hashName();
                    $img->move($imgPath, $imgName);

                    $oldImgObj->update([
                        'image' => $imgName,
                    ]);
                }
            }

            // Add New Images
            foreach ($images as $k => $img) {
                if (!in_array($k, $syncUpdated)) {
                    $imgName = $img->hashName();
                    $img->move($imgPath, $imgName);

                    $model->images()->create([
                        'image' => $imgName,
                    ]);
                }
            }
        }
    }

    private function saveProductTags($model, $tags)
    {
        if (!empty($tags)) {
            $tagsCollection = collect($tags);
            $filteredTags = $tagsCollection->filter(function ($value, $key) {
                return $value != null && $value != '';
            });
            $tags = $filteredTags->all();
            $model->tags()->sync($tags);
        } else {
            $model->tags()->detach();
        }
    }

    private function saveProductKeywords($model, $searchKeywords)
    {
        if (!empty($searchKeywords)) {
            $searchKeywordsCollection = collect($searchKeywords);
            $filteredSearchKeywords = $searchKeywordsCollection->filter(function ($value, $key) {
                return $value != null && $value != '';
            });
            $searchKeywords = $filteredSearchKeywords->all();

            $ids = [];
            foreach ($searchKeywords as $searchKeyword) {
                $keyword = SearchKeyword::firstOrCreate(
                    ['id' => $searchKeyword],
                    ['title' => $searchKeyword, 'status' => 1]
                );
                if ($keyword) {
                    $ids[] = $keyword->id;
                }
            }
            $model->searchKeywords()->sync($ids);
        } else {
            $model->searchKeywords()->detach();
        }
    }

    private function saveHomeCategories($model, $homeCategories)
    {
        if (!empty($homeCategories)) {
            $homeCategoriesCollection = collect($homeCategories);
            $filteredHomeCategoriesCollection = $homeCategoriesCollection->filter(function ($value, $key) {
                return $value != null && $value != '';
            });
            $home_categories = $filteredHomeCategoriesCollection->all();

            $model->homeCategories()->sync($home_categories);
        } else {
            $model->homeCategories()->detach();
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);
            if ($model) {
                File::delete($model->image);
            } ### Delete old image

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
        $query = $this->product->with('vendor')->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        });

        if ($request->input('search.value')) {
            $term = strtolower($request->input('search.value'));
            $query->where(function ($query) use ($term) {
                $query->where('id', 'like', '%' . $term . '%');
                $query->orWhereRaw('lower(sku) like (?)', ["%{$term}%"]);
                $query->orWhereRaw('lower(title) like (?)', ["%{$term}%"]);
                $query->orWhereRaw('lower(slug) like (?)', ["%{$term}%"]);
            });
        }

        $query = $this->filterDataTable($query, $request);

        return $query;
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

    public function productVariants($model, $request)
    {
        $oldValues = isset($request['variants']['_old']) ? $request['variants']['_old'] : [];

        $sync = $this->syncRelation($model, 'variants', $oldValues);

        if ($sync['deleted']) {
            $model->variants()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                foreach ($request['upateds_option_values_id'] as $key => $varianteId) {
                    $variation = $model->variants()->find($id);

                    $data = [
                        'sku' => $request['_variation_sku'][$id],
                        'price' => $request['_variation_price'][$id],
                        'status' => isset($request['_variation_status'][$id]) && $request['_variation_status'][$id] == 'on' ? 1 : 0,
                        'qty' => $request['_variation_qty'][$id],
                        "shipment" => isset($request["_vshipment"][$id]) ? $request["_vshipment"][$id] : null,
                        //                        'image' => $request['_v_images'][$id] ? path_without_domain($request['_v_images'][$id]) : $model->image
                    ];
                    if (isset($request['_v_images'][$id])) {
                        $imgName = $this->uploadVariantImage($request['_v_images'][$id]);
                        $data['image'] = 'uploads/products/' . $imgName;
                    }
                    $variation->update($data);

                    if (isset($request["_v_offers"][$id])) {
                        $this->variationOffer($variation, $request["_v_offers"][$id]);
                    }
                }
            }
        }


        if ($request['option_values_id']) {
            foreach ($request['option_values_id'] as $key => $value) {

                // dd($request->all(), $key);
                $data = [
                    'sku' => $request['variation_sku'][$key],
                    'price' => $request['variation_price'][$key],
                    'status' => isset($request['variation_status'][$key]) && $request['variation_status'][$key] == 'on' ? 1 : 0,
                    'qty' => $request['variation_qty'][$key],
                    "shipment" => isset($request["vshipment"][$key]) ? $request["vshipment"][$key] : null,
                    //                    'image' => $request['v_images'][$key] ? path_without_domain($request['v_images'][$key]) : $model->image
                ];
                if (!is_null($request['v_images']) && isset($request['v_images'][$key])) {
                    $imgName = $this->uploadVariantImage($request['v_images'][$key]);
                    $data['image'] = 'uploads/products/' . $imgName;
                } else {
                    $data['image'] = $model->image;
                }

                $variant = $model->variants()->create($data);


                if (isset($request["v_offers"][$key])) {
                    $this->variationOffer($variant, $request["v_offers"][$key]);
                }


                foreach ($value as $key2 => $value2) {
                    $variant->productValues()->create([
                        'option_value_id' => $value2,
                        'product_id' => $model['id'],
                    ]);
                }
            }
        }
    }

    public function productOffer($model, $request)
    {
        if (isset($request['offer_status']) && $request['offer_status'] == 'on') {
            $data = [
                'status' => ($request['offer_status'] == 'on') ? true : false,
                // 'offer_price' => $request['offer_price'] ? $request['offer_price'] : $model->offer->offer_price,
                'start_at' => $request['start_at'] ? $request['start_at'] : $model->offer->start_at,
                'end_at' => $request['end_at'] ? $request['end_at'] : $model->offer->end_at,
            ];

            if ($request['offer_type'] == 'amount' && !is_null($request['offer_price'])) {
                $data['offer_price'] = $request['offer_price'];
                $data['percentage'] = null;
            } elseif ($request['offer_type'] == 'percentage' && !is_null($request['offer_percentage'])) {
                $data['offer_price'] = null;
                $data['percentage'] = $request['offer_percentage'];
            } else {
                $data['offer_price'] = null;
                $data['percentage'] = null;
            }

            $model->offer()->updateOrCreate(['product_id' => $model->id], $data);
        } else {
            if ($model->offer) {
                $model->offer()->delete();
            }
        }
    }

    public function variationOffer($model, $request)
    {
        if (isset($request['status']) && $request['status'] == 'on') {
            $model->offer()->updateOrCreate(
                ['product_variant_id' => $model->id],
                [
                    'status' => ($request['status'] == 'on') ? true : false,
                    'offer_price' => $request['offer_price'] ? $request['offer_price'] : ($model->offer->offer_price ?? null),
                    'start_at' => $request['start_at'] ? $request['start_at'] : $model->offer->start_at,
                    'end_at' => $request['end_at'] ? $request['end_at'] : $model->offer->end_at,
                ]
            );
        } else {
            if ($model->offer) {
                $model->offer()->delete();
            }
        }
    }

    // addOnes
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

    public function deleteProductImg($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findProductImgById($id);

            if ($model) {
                File::delete('uploads/products/' . $model->image); ### Delete old image
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
                $dataInput = ["name" => $request->option_name];
                if (isset($request->add_ons_type) && !empty($request->add_ons_type)) {
                    $dataInput['type'] = $request->add_ons_type;
                    if (isset($request->options_count_select) && $request->options_count_select == 'on') {
                        $dataInput['options_count'] = $request->options_count ?? null;
                    }
                }

                if (isset($request->add_on_id) && !empty($request->add_on_id)) {
                    $addOn = AddOn::find($request->add_on_id);
                    $addOn->update($dataInput);
                } else {
                    $addOn = $product->addOns()->create($dataInput);
                }


                // Add AddOns options

                if (count($request->price) > 0 && count($request->rowId) > 0) {
                    foreach ($request->rowId as $k => $rowID) {
                        if (isset($request->add_on_id) && !empty($request->add_on_id)) {
                            ############################## Start Update Options ##############################
                            $OldAddOnOption = AddOnOption::find($rowID);

                            if ($OldAddOnOption) {
                                // Update Old
                                $OldAddOnOption->update([
                                    'price' => $request->price[$k],
                                    'default' => isset($request->default) && $request->default == $rowID ? true : null,
                                    "option" => $request->option[$rowID]
                                ]);
                            } else {
                                // Add New One
                                $newAddOnOption = $addOn->addonOptions()->create([
                                    'price' => $request->price[$k],
                                    'default' => isset($request->default) && $request->default == $rowID ? true : null,
                                    "option" => $request->option[$rowID]
                                ]);
                            }
                            ############################## Start Update Options ##############################
                        } else {
                            ############################## Start Add New Options ##############################
                            $addOnOption = $addOn->addonOptions()->create([
                                'price' => $request->price[$k],
                                'default' => isset($request->default) && $request->default == $rowID ? true : null,
                                "option" => $request->option[$rowID]
                            ]);


                            ############################## End Add New Options ##############################
                        }
                    }
                }

                DB::commit();
                return $this->findAddOnsById($addOn->id);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
