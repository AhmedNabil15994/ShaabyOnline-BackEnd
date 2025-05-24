<?php

namespace Modules\Catalog\Traits;

use Modules\Catalog\Entities\Category;

trait CatalogTrait
{
    public function getAllSubCategoryIds($categoryId)
    {
        $cat = Category::active()->find($categoryId);
        $allCats = [];
        if (!is_null($cat))
            $allCats = $cat->getAllRecursiveChildren()->pluck('id')->toArray();
        return $allCats;
    }

    public function checkRouteLocale($model, $columnValue, $column = 'slug')
    {
        if ($model && is_null($model->whereRaw("JSON_EXTRACT(" . $column . ", '$." . locale() . "') = '" . $columnValue . "'")->first()))
            return false;

        return true;
    }
}
