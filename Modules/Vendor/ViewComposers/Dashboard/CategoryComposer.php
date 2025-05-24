<?php

namespace Modules\Vendor\ViewComposers\Dashboard;

use Modules\Vendor\Repositories\Dashboard\CategoryRepository as Category;
use Illuminate\View\View;

class CategoryComposer
{
    public $mainCategories;
    public $sharedActiveCategories;
    public $allCategories;

    public function __construct(Category $category)
    {
        $this->mainCategories = $category->mainCategories();
        $this->sharedActiveCategories = $category->getAllActive();
        $this->allCategories = $category->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['mainVendorCategories' => $this->mainCategories, 'sharedActiveVendorCategories' => $this->sharedActiveCategories, 'allVendorCategories' => $this->allCategories]);
    }
}
