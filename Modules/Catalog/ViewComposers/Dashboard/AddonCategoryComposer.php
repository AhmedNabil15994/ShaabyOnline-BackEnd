<?php

namespace Modules\Catalog\ViewComposers\Dashboard;

use Modules\Catalog\Repositories\Dashboard\AddonCategoryRepository as AddonCategory;
use Illuminate\View\View;

class AddonCategoryComposer
{
    public $sharedActiveAddonCategories;

    public function __construct(AddonCategory $addonCategory)
    {
        $this->sharedActiveAddonCategories = $addonCategory->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['sharedActiveAddonCategories' => $this->sharedActiveAddonCategories]);
    }
}
