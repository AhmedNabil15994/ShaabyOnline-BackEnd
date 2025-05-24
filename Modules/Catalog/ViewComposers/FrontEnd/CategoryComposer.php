<?php

namespace Modules\Catalog\ViewComposers\FrontEnd;

use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;
use Illuminate\View\View;
use Cache;

class CategoryComposer
{
    protected $headerCategories;
    protected $categories;

    public function __construct(Category $category)
    {
        if (!in_array(request()->route()->getName(), ['frontend.categories.products'])) {
            $this->headerCategories = $category->getHeaderCategories();
        }
    }

    public function compose(View $view)
    {
        if (!in_array(request()->route()->getName(), ['frontend.categories.products'])) {
            $view->with([
                'headerCategories' => $this->headerCategories,
            ]);
        }
    }
}
