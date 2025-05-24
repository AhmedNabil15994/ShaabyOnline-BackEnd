<?php

namespace Modules\Catalog\ViewComposers\FrontEnd;

use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Illuminate\View\View;
use Cache;

class ProductComposer
{
    public function __construct(Product $product)
    {
        $this->products =  $product;
    }

    public function compose(View $view)
    {
        $view->with('products' , $this->products);
    }
}
