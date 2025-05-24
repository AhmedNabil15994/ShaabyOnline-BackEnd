<?php

namespace Modules\User\ViewComposers\FrontEnd;

use Modules\User\Repositories\FrontEnd\AddressRepository as Address;
use Illuminate\View\View;
use Cache;

class UserAddressesComposer
{
    public $addresses = [];

    public function __construct(Address $address)
    {
        $this->addresses =  $address->getAllByUsrId();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('addresses' , $this->addresses);
    }
}
