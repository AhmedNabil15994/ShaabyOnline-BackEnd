<?php

namespace Modules\Catalog\ViewComposers\Dashboard;

use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Illuminate\View\View;
use Cache;

class ProductComposer
{
    public $products;
    public $sharedActiveProducts;

    public function __construct(Product $product)
    {
        $this->products = $product->getAll();
        $this->sharedActiveProducts = $product->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['products' => $this->products, 'sharedActiveProducts' => $this->sharedActiveProducts]);
    }
}
