<?php

namespace Modules\Vendor\ViewComposers\Dashboard;

use Modules\Vendor\Repositories\Dashboard\PaymentRepository as Payment;
use Illuminate\View\View;
use Cache;

class PaymentComposer
{
    public $payments = [];

    public function __construct(Payment $payment)
    {
        $this->payments =  $payment->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('payments' , $this->payments);
    }
}
