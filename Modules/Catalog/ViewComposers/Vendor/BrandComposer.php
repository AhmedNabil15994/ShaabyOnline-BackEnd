<?php

namespace Modules\Catalog\ViewComposers\Vendor;

use Modules\Catalog\Repositories\Dashboard\BrandRepository as Brand;
use Illuminate\View\View;
use Cache;

class BrandComposer
{
    public $brands = [];

    public function __construct(Brand $category)
    {
        $this->brands =  $category->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('brands' , $this->brands);
    }
}
