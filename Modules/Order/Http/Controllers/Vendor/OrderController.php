<?php

namespace Modules\Order\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;
use Modules\Order\Mail\Dashboard\UpdateOrderStatusMail;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;
use Modules\Order\Repositories\Vendor\OrderRepository as Order;
use Modules\Order\Transformers\Vendor\OrderResource;

class OrderController extends Controller
{
    use SendNotification;

    protected $notification;
    protected $status;
    protected $order;

    public function __construct(Order $order, OrderStatus $status, Notification $notification)
    {
        $this->status = $status;
        $this->order = $order;
        $this->notification = $notification;
    }

    public function index()
    {
        return view('order::vendor.orders.index');
    }

    public function getAllOrders()
    {
        return view('order::vendor.all_orders.index');
    }

    public function getCompletedOrders()
    {
        return view('order::vendor.completed_orders.index');
    }

    public function getNotCompletedOrders()
    {
        return view('order::vendor.not_completed_orders.index');
    }

    public function getRefundedOrders()
    {
        return view('order::vendor.refunded_orders.index');
    }

    public function currentOrdersDatatable(Request $request)
    {
        return $this->basicDatatable($request, ['new_order', 'received', 'processing', 'is_ready']);
    }

    public function allOrdersDatatable(Request $request)
    {
        return $this->basicDatatable($request);
    }

    public function completedOrdersDatatable(Request $request)
    {
        return $this->basicDatatable($request, ['on_the_way', 'delivered']);
    }

    public function notCompletedOrdersDatatable(Request $request)
    {
        return $this->basicDatatable($request, ['failed']);
    }

    public function refundedOrdersDatatable(Request $request)
    {
        return $this->basicDatatable($request, ['refund']);
    }

    private function basicDatatable($request, $flags = [])
    {
        $datatable = DataTable::drawTable($request, $this->order->customQueryTable($request, $flags), 'orders');
        $datatable['data'] = OrderResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function show($id, $flag = null)
    {
        $order = $this->order->getVendorProductsByOrderId($id);
        if (!$order || ($flag != $order->order_flag && $flag != 'all_orders')) {
            abort(404);
        }

        $this->order->updateUnread($id);
        $statuses = $this->status->getAll();
        $order->allProducts = $order->orderProducts->mergeRecursive($order->orderVariations);

        return view('order::vendor.orders.show', compact('order', 'statuses', 'flag'));
    }

    public function refundOrder(Request $request, $id)
    {
        $res = $this->order->refundOrderOperation($request, $id);

        if ($res && $res[0] == 0) {

            return Response()->json([false, $res[1]]);
        }

        return Response()->json([true, __('apps::dashboard.general.message_update_success'), 'url' => route('vendor.orders.show', [$id, 'all_orders'])]);
    }

    public function updateAdminNote(Request $request, $id)
    {
        $order = $this->order->findById($id);
        if ($order) {

            $order->admin_note = $request->admin_note;
            $order->save();
        }
        return Response()->json([true, __('apps::dashboard.general.message_update_success'), 'note' => $request->admin_note]);
    }

    public function confirmPayment($id)
    {
        $res = $this->order->confirmPayment($id);
        return redirect()->route('vendor.orders.show', [$id, 'all_orders']);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->order->updateStatus($request, $id);

            if ($update) {

                ### Start Send E-mail & Push Notification To Mobile App Users ###
                $this->sendNotificationToUser($id);
                ### End Send E-mail & Push Notification To Mobile App Users ###

                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function sendNotificationToUser($id)
    {
        $order = $this->order->findById($id);
        if (!$order) {
            abort(404);
        }

        $tokens = $this->notification->getAllUserTokens($order->user_id);
        $locale = app()->getLocale();

        if (count($tokens) > 0) {
            $data = [
                'title' => __('order::vendor.orders.notification.title'),
                'body' => __('order::vendor.orders.notification.body') . ' - ' . $order->orderStatus->title,
                'type' => 'order',
                'id' => $order->id,
            ];

            $this->send($data, $tokens);
        }

        if ($order->user && !is_null($order->user->email)) {
            // Send E-mail to order user
            \Mail::to($order->user->email)->send(new UpdateOrderStatusMail($order));
        }

        return true;
    }

    public function destroy($id)
    {
        try {
            $delete = $this->order->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            if (empty($request['ids'])) {
                return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);
            }

            $deleteSelected = $this->order->deleteSelected($request);
            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
