<?php

namespace Modules\User\ViewComposers\Dashboard;

use Modules\User\Repositories\Dashboard\SellerRepository as Seller;
use Illuminate\View\View;
use Cache;

class SellerComposer
{
    public $sellers = [];

    public function __construct(Seller $seller)
    {
        $this->sellers =  $seller->getAllSellers();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sellers' , $this->sellers);
    }
}
