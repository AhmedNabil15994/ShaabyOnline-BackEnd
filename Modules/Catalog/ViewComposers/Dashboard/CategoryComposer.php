<?php

namespace Modules\Catalog\ViewComposers\Dashboard;

use Modules\Catalog\Repositories\Dashboard\CategoryRepository as Category;
use Illuminate\View\View;
use Cache;

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
        $view->with(['mainCategories' => $this->mainCategories, 'sharedActiveCategories' => $this->sharedActiveCategories, 'allCategories' => $this->allCategories]);
    }
}
