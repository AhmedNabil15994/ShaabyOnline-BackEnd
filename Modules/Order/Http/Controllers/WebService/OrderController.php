<?php

namespace Modules\Order\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;
use Modules\Company\Repositories\WebService\CompanyRepository as Company;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\Notification\Traits\SendNotificationTrait;
use Modules\Order\Entities\OrderStatusesHistory;
use Modules\Order\Entities\PaymentStatus;
use Modules\Order\Events\ActivityLog;
use Modules\Order\Events\VendorOrder;
use Modules\Order\Http\Requests\WebService\CreateOrderRequest;
use Modules\Order\Http\Requests\WebService\RateOrderRequest;
use Modules\Order\Jobs\SendOrderToMultipleJob;
use Modules\Order\Jobs\SendOrderToVendorsJob;
use Modules\Order\Mail\Dashboard\UpdateOrderStatusMail;
use Modules\Order\Repositories\WebService\OrderRepository as Order;
use Modules\Order\Transformers\WebService\OrderProductResource;
use Modules\Order\Transformers\WebService\OrderResource;
use Modules\Transaction\Services\MyFatoorahPaymentService;
use Modules\Transaction\Services\UPaymentService;
use Modules\User\Entities\User;
use Modules\User\Repositories\WebService\AddressRepository;
use Modules\Vendor\Repositories\WebService\VendorRepository as Vendor;
use Modules\Vendor\Traits\VendorTrait;

class OrderController extends WebServiceController
{
    use CartTrait, VendorTrait, SendNotificationTrait;

    protected $payment;
    protected $myFatoorahPayment;
    protected $order;
    protected $company;
    protected $catalog;
    protected $address;
    protected $vendor;
    protected $notification;

    public function __construct(
        Order $order,
        UPaymentService $payment,
        MyFatoorahPaymentService $myFatoorahPayment,
        Company $company,
        Catalog $catalog,
        AddressRepository $address,
        Vendor $vendor,
        Notification $notification
    ) {
        $this->payment = $payment;
        $this->myFatoorahPayment = $myFatoorahPayment;
        $this->order = $order;
        $this->company = $company;
        $this->catalog = $catalog;
        $this->address = $address;
        $this->vendor = $vendor;
        $this->notification = $notification;
    }

    public function createOrder(CreateOrderRequest $request)
    {
        if (auth('api')->check()) {
            $userToken = auth('api')->user()->id;
        } else {
            $userToken = $request->user_id;
        }

        // Check if address is not found
        if ($request->address_type == 'selected_address') {
            // get address by id
            $companyDeliveryFees = getCartConditionByName($userToken, 'company_delivery_fees');
            $addressId = isset($companyDeliveryFees->getAttributes()['address_id'])
            ? $companyDeliveryFees->getAttributes()['address_id']
            : null;
            $address = $this->address->findByIdWithoutAuth($addressId);
            if (!$address) {
                return $this->error(__('user::webservice.address.errors.address_not_found'), [], 422);
            }

        }

        foreach (getCartContent($userToken) as $key => $item) {

            if ($item->attributes->product->product_type == 'product') {
                $cartProduct = $item->attributes->product;
                $product = $this->catalog->findOneProduct($cartProduct->id);
                if (!$product) {
                    return $this->error(__('cart::api.cart.product.not_found') . $cartProduct->id, [], 422);
                }

                ### Start - Check Single Addons Selections - Validation ###
                $selectedAddons = $item->attributes->has('addonsOptions') ? $item->attributes['addonsOptions']['data'] : [];
                $addOnsCheck = $this->checkProductAddonsValidation($selectedAddons, $product);
                if (gettype($addOnsCheck) == 'string') {
                    return $this->error($addOnsCheck . ' : ' . $cartProduct->translate(locale())->title, [], 422);
                }

                ### End - Check Single Addons Selections - Validation ###

                $product->product_type = 'product';
            } else {
                $cartProduct = $item->attributes->product;
                $product = $this->catalog->findOneProductVariant($cartProduct->id);
                if (!$product) {
                    return $this->error(__('cart::api.cart.product.not_found') . $cartProduct->id, [], 422);
                }

                $product->product_type = 'variation';
            }

            $checkPrdFound = $this->productFound($product, $item);
            if ($checkPrdFound) {
                return $this->error($checkPrdFound, [], 422);
            }

            // $checkPrdStatus = $this->checkProductActiveStatus($product, $request);
            $checkPrdStatus = $this->checkProductStatus($product);
            if ($checkPrdStatus) {
                return $this->error($checkPrdStatus, [], 422);
            }

            if (!is_null($product->qty)) {
                $checkPrdQty = $this->checkQty($product);
                if ($checkPrdQty) {
                    return $this->error($checkPrdQty, [], 422);
                }

            }

            if (!is_null($product->qty)) {
                $checkPrdMaxQty = $this->checkMaxQty($product, $item->quantity);
                if ($checkPrdMaxQty) {
                    return $this->error($checkPrdMaxQty, [], 422);
                }

            }

            $checkVendorStatus = $this->vendorStatus($product);
            if ($checkVendorStatus) {
                return $this->error($checkVendorStatus, [], 422);
            }

        }

        $order = $this->order->create($request, $userToken);
        if (!$order) {
            return $this->error('error', [], 422);
        }

        if ($request['payment'] == 'upayment' && getCartTotal($userToken) > 0) {

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

            $payment = $this->payment->send($order, 'knet', 'api-order', $extraData);
            if (is_null($payment)) {
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
            } else {
                return $this->response(['paymentUrl' => $payment, 'order_id' => $order->id]);
            }

        } elseif ($request['payment'] == 'myfatourah' && getCartTotal($userToken) > 0) {
            $payment = $this->myFatoorahPayment->send($order, "knet", "api-order");
            if ($payment) {
                return $this->response(['paymentUrl' => $payment, 'order_id' => $order->id]);
            } else {
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
            }
        }

        $newOrder = $this->order->findById($order->id);

        $this->fireLog($newOrder);
        $this->clearCart($userToken);

        return $this->response(new OrderResource($newOrder));
    }

    public function webhooks(Request $request)
    {
        $this->order->updateOrder($request);
    }

    public function success(Request $request)
    {
        $order = $this->order->updateOrder($request);
        if ($order) {
            $orderDetails = $this->order->findById($request['OrderID']);
            $userToken = $orderDetails->user_id ?? $orderDetails->user_token;
            if ($orderDetails) {
                $this->fireLog($orderDetails);
                $this->clearCart($userToken);
                return $this->response(new OrderResource($orderDetails));
            } else {
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
            }

        }
    }

    public function failed(Request $request)
    {
        $this->order->updateOrder($request);
        return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
    }

    public function userOrdersList(Request $request)
    {
        if (auth('api')->check()) {
            $userId = auth('api')->id();
            $userColumn = 'user_id';
        } else {
            $userId = $request->user_token ?? 'not_found';
            $userColumn = 'user_token';
        }
        $orders = $this->order->getAllByUser($userId, $userColumn);
        return $this->response(OrderResource::collection($orders));
    }

    public function getOrderDetails(Request $request, $id)
    {
        $order = $this->order->findById($id);

        if (!$order) {
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);
        }

        $allOrderProducts = $order->orderProducts->mergeRecursive($order->orderVariations);
        return $this->response(OrderProductResource::collection($allOrderProducts));
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

        // if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
        if ($order->vendors[0]->use_app_drivers == 1) {
            $this->fireNotificationToDrivers($order);
        }
        // }

        $this->sendNotifications($order);
    }

    public function sendNotifications($order)
    {
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

    private function fireNotificationToDrivers($order)
    {
        // fire notification to drivers that have the same order state
        $orderStateId = optional($order->orderAddress)->state_id ?? null;
        $matchedDrivers = User::whereHas('driverStates', function ($query) use ($orderStateId) {
            $query->where('driver_state.status', 1);
            $query->where('driver_state.state_id', $orderStateId);
        })->get();

        if ($matchedDrivers->count() > 0) {
            foreach ($matchedDrivers as $key => $driver) {
                $this->sendMobileNotify($order, $driver->id, 'driver_app');
                $driverEmail = $driver->email ?? null;
                if (!is_null($driverEmail)) {
                    $this->sendEmailNotify($order, $driverEmail);
                }
            }
        }
    }

    public function sendMobileNotify($order, $userId, $googleAPIKeyType = 'main_app')
    {
        $tokens = $this->notification->getAllUserTokens($userId);
        $locale = app()->getLocale();
        if (count($tokens) > 0) {
            $data = [
                'title' => __('order::dashboard.orders.notification.new_order_title'),
                'body' => __('order::dashboard.orders.notification.new_order_body'),
                'type' => 'order',
                'id' => $order->id,
            ];
            $this->send($data, $tokens, $googleAPIKeyType);
        }
        return true;
    }

    public function sendEmailNotify($order, $email)
    {
        \Mail::to($email)->send(new UpdateOrderStatusMail($order));
        return true;
    }

    public function rateOrder(RateOrderRequest $request, $id)
    {
        $order = $this->order->findByIdWithUserId($id);
        if (!$order) {
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);
        }

        $ratingOrder = $this->order->checkRatingOrder($id);
        if (!is_null($ratingOrder)) {
            return $this->error(__('order::api.orders.validations.order_rated'), [], 422);
        }

        $vendors = $order->vendors->pluck('id')->toArray() ?? [];
        $vendorId = !empty($vendors) ? $vendors[0] : null;
        $rate = $this->order->rateOrder($request, $order->id, $vendorId);
        return $this->response($rate);
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
            $this->fireLog($orderDetails);
            $userToken = $orderDetails->user_id ?? ($orderDetails->user_token ?? null);
            if ($userToken) {
                $this->clearCart($userToken);
            }
            return $this->response(new OrderResource($orderDetails));
        } else {
            return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
        }

    }

    public function myfatoorahFailed(Request $request)
    {
        logger('MyFatoorah::failed');
        logger($request->all());
        $response = $this->getMyFatoorahTransactionDetails($request);
        $orderCheck = $this->order->updateMyFatoorahOrder($request, $response['status'], $response['transactionsData'], $response['orderId']);
        return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
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

    public function cancelOrderPayment(Request $request, $id)
    {
        if (auth('api')->check()) {
            $userData['column'] = 'user_id';
            $userData['value'] = auth('api')->id();
        } else {
            $userData['column'] = 'user_token';
            $userData['value'] = $request->user_token;
        }

        $order = $this->order->checkOrderPendingPayment($id, $userData);
        if ($order) {
            $orderStatusId = $this->order->getOrderStatusByFlag('failed')->id;
            $paymentStatusId = optional(PaymentStatus::where('flag', 'failed')->first())->id ?? $order->payment_status_id;

            $order->update([
                'order_status_id' => $orderStatusId, // failed
                'payment_status_id' => $paymentStatusId, // failed
                'payment_confirmed_at' => null,
                'increment_qty' => true,
            ]);

            // Add Order Status History
            OrderStatusesHistory::create([
                'order_id' => $order->id,
                'order_status_id' => $orderStatusId, // failed
                'user_id' => auth('api')->check() ? auth('api')->id() : null,
            ]);

            if ($order->orderProducts) {
                foreach ($order->orderProducts as $i => $orderProduct) {
                    if (!is_null($orderProduct->product->qty)) {
                        $orderProduct->product->increment('qty', $orderProduct->qty);
                    }
                }
            }

            if ($order->orderVariations) {
                foreach ($order->orderVariations as $i => $orderProduct) {
                    if (!is_null($orderProduct->variant->qty)) {
                        $orderProduct->variant->increment('qty', $orderProduct->qty);
                    }
                }
            }

        }
        return $this->response(null);
    }

}
