<?php

namespace Modules\Order\Http\Controllers\FrontEnd;

use Cart;
use Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Modules\Order\Events\ActivityLog;
use Modules\Order\Events\VendorOrder;
use Modules\Catalog\Traits\ShoppingCartTrait;

use Modules\Transaction\Services\UPaymentService;
use Modules\Transaction\Services\MyFatoorahPaymentService;

use Modules\Order\Http\Requests\FrontEnd\CreateOrderRequest;
use Modules\Order\Repositories\FrontEnd\OrderRepository as Order;
use Modules\Order\Notifications\FrontEnd\AdminNewOrderNotification;
use Modules\Order\Notifications\FrontEnd\UserNewOrderNotification;
use Modules\Order\Notifications\FrontEnd\VendorNewOrderNotification;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\User\Entities\User;
use Modules\Vendor\Traits\VendorTrait;
use Modules\Order\Jobs\SendOrderToMultipleJob;
use Modules\Order\Jobs\SendOrderToVendorsJob;

//use Modules\Transaction\Services\PaymentService;
//use Modules\Transaction\Services\UPaymentTestService;

class OrderController extends Controller
{
    use ShoppingCartTrait, VendorTrait;

    protected $payment;
    protected $myFatoorahPayment;
    protected $order;
    protected $product;
    protected $vendor;

    function __construct(
        Order $order,
        UPaymentService $payment,
        MyFatoorahPaymentService $myFatoorahPayment,
        Product $product,
        Vendor $vendor
    ) {
        $this->payment = $payment;
        $this->myFatoorahPayment = $myFatoorahPayment;
        $this->order = $order;
        $this->product = $product;
        $this->vendor = $vendor;
    }

    public function index()
    {
        $ordersIDs = isset($_COOKIE[config('core.config.constants.ORDERS_IDS')]) && !empty($_COOKIE[config('core.config.constants.ORDERS_IDS')]) ? (array)\GuzzleHttp\json_decode($_COOKIE[config('core.config.constants.ORDERS_IDS')]) : [];

        if (auth()->user()) {
            $orders = $this->order->getAllByUser($ordersIDs);
            return view('order::frontend.orders.index', compact('orders'));
        } else {
            $orders = count($ordersIDs) > 0 ? $this->order->getAllGuestOrders($ordersIDs) : [];
            return view('order::frontend.orders.index', compact('orders'));
        }
    }

    public function invoice($id)
    {
        if (auth()->user())
            $order = $this->order->findByIdWithUserId($id);
        else
            $order = $this->order->findGuestOrderById($id);

        if (!$order)
            return abort(404);

        $order->orderProducts = $order->orderProducts->mergeRecursive($order->orderVariations);
        return view('order::frontend.orders.details', compact('order'));
    }

    public function reOrder($id)
    {
        $order = $this->order->findByIdWithUserId($id);
        $order->orderProducts = $order->orderProducts->mergeRecursive($order->orderVariations);
        return view('order::frontend.orders.re-order', compact('order'));
    }

    public function guestInvoice()
    {
        $savedID = [];
        if (isset($_COOKIE[config('core.config.constants.ORDERS_IDS')]) && !empty($_COOKIE[config('core.config.constants.ORDERS_IDS')])) {
            $savedID = (array)\GuzzleHttp\json_decode($_COOKIE[config('core.config.constants.ORDERS_IDS')]);
        }
        $id = count($savedID) > 0 ? $savedID[count($savedID) - 1] : 0;
        $order = $this->order->findByIdWithGuestId($id);
        if (!$order)
            abort(404);

        $order->orderProducts = $order->orderProducts->mergeRecursive($order->orderVariations);
        return view('order::frontend.orders.invoice', compact('order'))->with([
            'alert' => 'success', 'status' => __('order::frontend.orders.index.alerts.order_success')
        ]);
    }

    public function createOrder(CreateOrderRequest $request)
    {
        if (auth('api')->check())
            $userToken = auth('api')->user()->id;
        else
            $userToken = $request->user_id;

        $errors1 = [];
        $errors2 = [];
        $errors3 = [];
        $errors4 = [];
        $errors5 = [];

        foreach (getCartContent() as $key => $item) {

            if ($item->attributes->product->product_type == 'product') {
                $cartProduct = $item->attributes->product;
                $product = $this->product->findOneProduct($cartProduct->id);
                if (!$product)
                    return redirect()->back()->with(['alert' => 'danger', 'status' => __('cart::api.cart.product.not_found') . $cartProduct->id]);

                ### Start - Check Single Addons Selections - Validation ###
                $selectedAddons = $item->attributes->has('addonsOptions') ? $item->attributes['addonsOptions']['data'] : [];
                $addOnsCheck = $this->checkProductAddonsValidation($selectedAddons, $product);
                if (gettype($addOnsCheck) == 'string')
                    return redirect()->back()->with(['alert' => 'danger', 'status' => $addOnsCheck . ' : ' . $cartProduct->translate(locale())->title]);
                ### End - Check Single Addons Selections - Validation ###

                $product->product_type = 'product';
            } else {
                $cartProduct = $item->attributes->product;
                $product = $this->product->findOneProductVariant($cartProduct->id);
                if (!$product)
                    return redirect()->back()->with(['alert' => 'danger', 'status' => __('cart::api.cart.product.not_found') . $cartProduct->id]);

                $product->product_type = 'variation';
            }

            $productFound = $this->productFound($product, $item);
            if ($productFound) {
                $errors1[] = $productFound;
            }

            // $activeStatus = $this->checkActiveStatus($product, $request);
            $activeStatus = $this->checkProductStatus($product);
            if ($activeStatus) {
                $errors2[] = $activeStatus;
            }

            if (!is_null($product->qty)) {
                $maxQtyInCheckout = $this->checkMaxQtyInCheckout($product, $item->quantity, $cartProduct->qty);
                if ($maxQtyInCheckout) {
                    $errors3[] = $maxQtyInCheckout;
                }
            }

            $vendorStatusError = $this->vendorStatus($product);
            if ($vendorStatusError) {
                $errors4[] = $vendorStatusError;
            }

            if (!is_null($product->qty)) {
                $checkPrdQty = $this->checkQty($product);
                if ($checkPrdQty) {
                    $errors5[] = $checkPrdQty;
                }
            }
        }

        if ($errors1 || $errors2 || $errors3 || $errors4 || $errors5) {
            $errors = new MessageBag([
                'productCart' => $errors1,
                'productCart2' => $errors2,
                'productCart3' => $errors3,
                'productCart4' => $errors4,
                'productCart5' => $errors5,
            ]);
            return redirect()->back()->with(["errors" => $errors]);
        }

        $order = $this->order->create($request);
        if (!$order)
            return $this->redirectToFailedPayment();

        if ($request['payment'] == 'upayment' && getCartTotal() > 0) {

            $extraData = [];
            if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                $vendorId = getCartContent($userToken)->first()->attributes['vendor_id'] ?? null;
                $vendorModel = $this->vendor->findById($vendorId);
                $extraData['ibans'] = $vendorModel->payment_data['ibans'] ?? null;
            } else {
                $extraData['ibans'] = null;
            }

            if (config('setting.supported_payments.upayment.account_type') == 'vendor_account') {
                $equationCommission = $this->calculateVendorCommissions($order->vendors);
                $order->update([
                    'payment_commissions' => [
                        'knet' => $equationCommission['knetEquation'],
                        'cc' => $equationCommission['ccEquation'],
                    ],
                ]);
                $extraData['knetEquation'] = $equationCommission['knetEquation'];
                $extraData['ccEquation'] = $equationCommission['ccEquation'];
            }

            $paymentUrl = $this->payment->send($order, 'knet', 'frontend-order', $extraData);
            if (is_null($paymentUrl))
                return $this->redirectToFailedPayment();
            else
                return redirect()->away($paymentUrl);
        } elseif ($request['payment'] == 'myfatourah' && getCartTotal() > 0) {
            $paymentUrl = $this->myFatoorahPayment->send($order, "knet", "frontend-order");
            if (is_null($paymentUrl)) {
                return $this->redirectToFailedPayment();
            } else
                return redirect()->away($paymentUrl);
        }
        return $this->redirectToPaymentOrOrderPage($request, $order);
    }

    public function webhooks(Request $request)
    {
        $this->order->updateOrder($request);
    }

    public function success(Request $request)
    {
        $order = $this->order->updateOrder($request);
        return $order ? $this->redirectToPaymentOrOrderPage($request) : $this->redirectToFailedPayment();
    }

    public function failed(Request $request)
    {
        $this->order->updateOrder($request);
        return $this->redirectToFailedPayment();
    }

    public function redirectToPaymentOrOrderPage($data, $order = null)
    {
        $order = ($order == null) ? $this->order->findById($data['OrderID']) : $this->order->findById($order->id);
        $this->sendNotifications($order);
        $this->clearCart();
        return $this->redirectToInvoiceOrder($order);
    }

    public function redirectToInvoiceOrder($order)
    {
        ################# Start Store Guest Orders In Browser Cookie ######################
        if (isset($_COOKIE[config('core.config.constants.ORDERS_IDS')]) && !empty($_COOKIE[config('core.config.constants.ORDERS_IDS')])) {
            $cookieArray = (array)\GuzzleHttp\json_decode($_COOKIE[config('core.config.constants.ORDERS_IDS')]);
        }
        $cookieArray[] = $order['id'];
        setcookie(config('core.config.constants.ORDERS_IDS'), \GuzzleHttp\json_encode($cookieArray), time() + (5 * 365 * 24 * 60 * 60), '/'); // expires at 5 year
        ################# End Store Guest Orders In Browser Cookie ######################

        if (auth()->user())
            return redirect()->route('frontend.orders.invoice', $order->id)->with([
                'alert' => 'success', 'status' => __('order::frontend.orders.index.alerts.order_success')
            ]);

        return redirect()->route('frontend.orders.guest.invoice');
    }

    public function redirectToFailedPayment()
    {
        return redirect()->route('frontend.checkout.index')->with([
            'alert' => 'danger', 'status' => __('order::frontend.orders.index.alerts.order_failed')
        ]);
    }

    public function sendNotifications($order)
    {
        $this->fireLog($order);

        $email = optional($order->orderAddress)->email ?? (optional($order->user)->email ?? null);
        if (!is_null($email)) {
            $emails[] = $email;
            dispatch(new SendOrderToMultipleJob($order, $emails, 'user_email'));
        }

        if (config('setting.contact_us.email')) {
            $emails = [];
            $emails[] = config('setting.contact_us.email');
            $adminsEmails = $this->getAllAdminsEmails();
            $emails = array_merge($emails, $adminsEmails);
            dispatch(new SendOrderToMultipleJob($order, $emails, 'admin_email'));
        }

        if ($order->vendors) {
            dispatch(new SendOrderToVendorsJob($order));
        }
    }

    public function pluckVendorEmails($order)
    {
        foreach ($order->vendors as $k => $value) {
            $vendor = $this->vendor->findById($value->id);
            if ($vendor) {
                $emails = $vendor->sellers->pluck('email');
                return $emails;
            }
        }
        return [];
    }

    public function fireLog($order)
    {
        $dashboardUrl = LaravelLocalization::localizeUrl(url(route('dashboard.orders.show', [$order->id, 'current_orders'])));
        $data = [
            'id' => $order->id,
            'type' => 'orders',
            'url' => $dashboardUrl,
            'description_en' => 'New Order',
            'description_ar' => 'طلب جديد ',
        ];
        $data2 = [];

        if ($order->vendors) {
            foreach ($order->vendors as $k => $value) {
                $vendor = $this->vendor->findById($value->id);
                if ($vendor) {
                    $vendorUrl = LaravelLocalization::localizeUrl(url(route('vendor.orders.show', [$order->id, 'current_orders'])));
                    $data2 = [
                        'ids' => $vendor->sellers->pluck('id'),
                        'type' => 'vendor',
                        'url' => $vendorUrl,
                        'description_en' => 'New Order',
                        'description_ar' => 'طلب جديد',
                    ];
                }
            }
        }

        event(new ActivityLog($data));
        if (count($data2) > 0) {
            event(new VendorOrder($data2));
        }
    }

    ############## Start: MyFatoorah Functions ############
    public function myfatoorahSuccess(Request $request)
    {
        logger('MyFatoorah::success');
        logger($request->all());
        $response = $this->getMyFatoorahTransactionDetails($request);
        $orderCheck = $this->order->updateMyFatoorahOrder($request, $response['status'], $response['transactionsData'], $response['orderId']);
        $orderDetails = $this->order->findById($response['orderId']);
        if ($orderCheck && $orderDetails) {
            $this->sendNotifications($orderDetails);
            $userToken = $orderDetails->user_id ?? ($orderDetails->user_token ?? null);
            if ($userToken) {
                $this->clearCart($userToken);
            }

            return $this->redirectToInvoiceOrder($orderDetails);
        } else
            return $this->redirectToFailedPayment();
    }

    public function myfatoorahFailed(Request $request)
    {
        logger('MyFatoorah::failed');
        logger($request->all());
        $response = $this->getMyFatoorahTransactionDetails($request);
        $orderCheck = $this->order->updateMyFatoorahOrder($request, $response['status'], $response['transactionsData'], $response['orderId']);
        return $this->redirectToFailedPayment();
    }

    private function getMyFatoorahTransactionDetails($request)
    {
        // Get transaction details
        $response = $this->myFatoorahPayment->getTransactionDetails($request->paymentId);
        logger('Get transaction details');
        logger($response);
        $status = strtoupper($response['InvoiceStatus']);
        $orderId = $response['UserDefinedField'];
        $transactionsData = $response['InvoiceTransactions'][0] ?? [];
        return [
            'status' => $status,
            'orderId' => $orderId,
            'transactionsData' => $transactionsData,
        ];
    }
    ############## End: MyFatoorah Functions ############

    private function getAllAdminsEmails()
    {
        return User::whereHas('roles.perms', function ($query) {
            $query->where('name', 'dashboard_access');
        })
            ->pluck('email')
            ->toArray();
    }
}
