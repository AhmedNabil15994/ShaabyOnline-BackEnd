<?php

namespace Modules\Catalog\ViewComposers\FrontEnd;

use Modules\Catalog\Repositories\FrontEnd\BrandRepository as Brand;
use Illuminate\View\View;
use Cache;

class BrandComposer
{
    public function __construct(Brand $brand)
    {
        $this->brand =  $brand->getAllActive();
    }

    public function compose(View $view)
    {
        $view->with('brands' , $this->brand);
    }
}
