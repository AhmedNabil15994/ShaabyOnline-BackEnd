<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Repositories\Dashboard\StateRepository as State;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Catalog\Http\Requests\FrontEnd\AddAddressRequest;
use Modules\Catalog\Http\Requests\FrontEnd\SelectAddressRequest;
use Modules\Catalog\Http\Requests\FrontEnd\CheckoutLimitationRequest;
use Modules\User\Repositories\FrontEnd\AddressRepository as Address;
use Modules\Vendor\Entities\Vendor;

//use Modules\Vendor\Repositories\FrontEnd\DeliveryChargeRepository as Charge;

class OrderAddressController extends Controller
{
    use ShoppingCartTrait;

//    protected $charge;
    protected $address;
    protected $state;

    function __construct(Address $address/*, Charge $charge*/, State $state)
    {
//        $this->charge = $charge;
        $this->address = $address;
        $this->state = $state;
    }

    public function index(/*CheckoutLimitationRequest*/ Request $request)
    {
        return 'Coming soon ...';

//        return view('catalog::frontend.address.index');
    }

    public function chooseAddress(Request $request)
    {
        return view('catalog::frontend.address.choose-address');
    }

    /*public function userDeliveryCharge(SelectAddressRequest $request)
    {
        $address = $this->address->findById($request['address']);

        $charge = $this->charge->findDeliveryCharge(Cart::getCondition('vendor')->getType(), $address->state->id);

        if (!$charge)
            return redirect()->back()->with(['alert' => 'warning', 'status' => __('catalog::frontend.cart.no_delivery_charge_to_area')]);

        // Save user state for later operations
        set_cookie_value('autoSaveArea', $address->state->id);

        $this->DeliveryChargeCondition($charge['delivery'], $address);

        return redirect()->route('frontend.checkout.index');
    }*/

    /*public function guestDeliveryCharge(AddAddressRequest $request)
    {
        $charge = $this->charge->findDeliveryCharge(Cart::getCondition('vendor')->getType(), $request->state_id);

        if (!$charge)
            return redirect()->back()->with(['alert' => 'warning', 'status' => __('catalog::frontend.cart.no_delivery_charge_to_area')]);

        $this->DeliveryChargeCondition($charge['delivery'], $request->except('_token'));

        // Save user contact info
        set_cookie_value(config('core.config.constants.CONTACT_INFO'), \GuzzleHttp\json_encode($request->except('_token')));

        return redirect()->route('frontend.checkout.payment_methods.index');
    }*/

    /*public function saveDeliveryCharge(Request $request)
    {
        $charge = $this->charge->findDeliveryCharge(Cart::getCondition('vendor')->getType(), $request->state_id);
        if (!$charge)
            return redirect()->back()->with(['alert' => 'warning', 'status' => __('catalog::frontend.cart.no_delivery_charge_to_area')]);

        $this->DeliveryChargeCondition($charge['delivery'], $request->except('_token'));

        return redirect()->back();
    }*/

}
