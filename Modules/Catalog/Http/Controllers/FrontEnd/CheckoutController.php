<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\State;
use Modules\Catalog\Http\Requests\FrontEnd\CheckoutInformationRequest;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Catalog\Http\Requests\FrontEnd\CheckoutLimitationRequest;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Company\Entities\DeliveryCharge;
use Modules\Vendor\Repositories\FrontEnd\PaymentRepository as PaymentMethods;
use Modules\Company\Repositories\FrontEnd\CompanyRepository as Company;
use Modules\Core\Traits\CoreTrait;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as VendorRepo;
use Modules\Vendor\Entities\Vendor;
use Modules\Vendor\Entities\VendorDeliveryCharge;

class CheckoutController extends Controller
{
    use ShoppingCartTrait, CoreTrait;

    protected $product;
    protected $payment;
    protected $company;
    protected $vendor;

    function __construct(Product $product, PaymentMethods $payment, Company $company, VendorRepo $vendor)
    {
        $this->product = $product;
        $this->payment = $payment;
        $this->company = $company;
        $this->vendor = $vendor;
    }

    public function index(Request $request)
    {
        $paymentMethods = $this->payment->getAll();

        if (config('setting.other.select_shipping_provider') == 'shipping_company') {
            $companyId = config('setting.other.shipping_company') ?? 0;
            $deliveryProvider = $this->company->findById($companyId, ['deliveryTimes']);
        } else {
            $vendorId = getCartContent()->first()->attributes['vendor_id'] ?? null;
            $deliveryProvider = $this->vendor->findById($vendorId, ['deliveryTimes']);
        }

        $deliveryTimes = [];
        $deliveryProviderId = null;
        if ($deliveryProvider && !empty($deliveryProvider->delivery_time_types)) {
            $deliveryTimes = $this->buildDeliveryTimes($deliveryProvider);
            $deliveryProviderId = $deliveryProvider->id;
        }

        return view('catalog::frontend.checkout.index', compact('paymentMethods', 'deliveryTimes', 'deliveryProviderId'));
    }

    public function saveCheckoutInformation(CheckoutInformationRequest $request)
    {
        abort(404);
    }

    public function getContactInfo(Request $request)
    {
        $savedContactInfo = !empty(get_cookie_value(config('core.config.constants.CONTACT_INFO'))) ? (array)\GuzzleHttp\json_decode(get_cookie_value(config('core.config.constants.CONTACT_INFO'))) : [];
        return view('catalog::frontend.checkout.index', compact('savedContactInfo'));
    }

    public function getPaymentMethods(Request $request)
    {
        $cartAttributes = isset(Cart::getConditions()['delivery_fees']) && !empty(Cart::getConditions()['delivery_fees']) ? Cart::getConditions()['delivery_fees']->getAttributes() : null;

        if ($cartAttributes && $cartAttributes['address'] != null) {

            $address = Cart::getCondition('delivery_fees')->getAttributes()['address'];
            $vendor = Vendor::find(Cart::getCondition('vendor')->getType());

            return view('catalog::frontend.checkout.index', compact('address', 'vendor'));
        } else {
            return redirect()->back();
        }
    }

    public function getStateDeliveryPrice(Request $request)
    {
        if (auth()->check())
            $userToken = auth()->user()->id ?? null;
        else
            $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;

        if (is_null($userToken))
            return response()->json(["errors" => __('apps::frontend.general.user_token_not_found')], 422);

        if (isset($request->type) && $request->type === 'selected_state') {

            $request->company_id = config('setting.other.shipping_company') ?? 0;
            if (isset($request->state_id) && $request->state_id != 0 && !empty($request->state_id)) {

                if (config('setting.other.select_shipping_provider') == 'shipping_company') {
                    $request->company_id = config('setting.other.shipping_company') ?? 0;
                    $deliveryFeesObject = DeliveryCharge::active()->where('state_id', $request->state_id)->where('company_id', $request->company_id)->first();
                } elseif (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                    $vendorId = getCartContent()->first()->attributes['vendor_id'] ?? null;
                    $request->request->add(['vendor_id' => $vendorId]);
                    $deliveryFeesObject = VendorDeliveryCharge::active()->where('state_id', $request->state_id)->where('vendor_id', $vendorId)->first();
                } else {
                    $deliveryFeesObject = null;
                }

                $stateObject = State::with('city')->active()->find($request->state_id);

                if ($deliveryFeesObject) {
                    $this->companyDeliveryChargeCondition($request, $deliveryFeesObject->delivery, $userToken, $deliveryFeesObject->delivery_time, $stateObject->city_id ?? null, $stateObject->city->country_id ?? null);
                    $condition = Cart::session($userToken)->getCondition('company_delivery_fees');
                    $deliveryPrice = $condition != null ? $condition->getValue() : 0;
                    $data = [
                        'price' => $deliveryFeesObject->delivery,
                        'delivery_time_note' => $deliveryFeesObject->delivery_time,
                        'totalDeliveryPrice' => number_format($deliveryPrice, 3),
                        'total' => number_format(getCartTotal(), 3),
                    ];

                    return response()->json(['success' => true, 'data' => $data]);
                } else {
                    if (Cart::session($userToken)->getCondition('company_delivery_fees') != null) {
                        Cart::session($userToken)->removeCartCondition('company_delivery_fees');
                    }
                    $data = [
                        'price' => null,
                        'delivery_time_note' => null,
                        'totalDeliveryPrice' => 0,
                        'total' => number_format(getCartTotal(), 3),
                    ];
                    return response()->json(['success' => false, 'data' => $data, 'errors' => __('catalog::frontend.checkout.validation.state_not_supported_by_company')], 422);
                }
            } else {
                return response()->json(['success' => false, 'errors' => __('catalog::frontend.checkout.validation.please_choose_state')], 422);
            }
        } else {
            $data = [
                'price' => null,
                'delivery_time_note' => null,
                'totalDeliveryPrice' => 0,
                'total' => number_format(getCartTotal(), 3),
            ];
            return response()->json(['success' => true, 'data' => $data]);
        }
    }
}
