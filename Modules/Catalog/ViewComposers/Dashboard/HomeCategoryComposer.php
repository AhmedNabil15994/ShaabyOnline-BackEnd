<?php

namespace Modules\Catalog\ViewComposers\Dashboard;

use Modules\Catalog\Repositories\Dashboard\HomeCategoryRepository as Category;
use Illuminate\View\View;
use Cache;

class HomeCategoryComposer
{
    public $homeCategories;


    public function __construct(Category $category)
    {
        $this->homeCategories = $category->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['homeCategories' => $this->homeCategories]);
    }
}
