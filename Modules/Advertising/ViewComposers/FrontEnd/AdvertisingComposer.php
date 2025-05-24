<?php

namespace Modules\Advertising\ViewComposers\FrontEnd;

use Modules\Advertising\Repositories\FrontEnd\AdvertisingRepository as Advertising;
use Illuminate\View\View;
use Cache;

class AdvertisingComposer
{
    public $advertisements = [];

    public function __construct(Advertising $advertisements)
    {
        $this->advertisements =  $advertisements->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('advertisements' , $this->advertisements);
    }
}
