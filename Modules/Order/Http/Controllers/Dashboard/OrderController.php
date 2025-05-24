<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Modules\Core\Traits\DataTable;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;
use Modules\Order\Constant\OrderStatus as ConstantOrderStatus;
use Modules\Order\Http\Requests\Dashboard\OrderDriverRequest;
use Modules\Order\Mail\Dashboard\UpdateOrderStatusMail;
use Modules\Order\Repositories\Dashboard\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;
use Modules\Order\Transformers\Dashboard\OrderResource;

class OrderController extends Controller
{
    use SendNotification;

    protected $order;
    protected $status;
    protected $notification;
    protected $product;

    public function __construct(Order $order, OrderStatus $status, Notification $notification, Product $product)
    {
        $this->status = $status;
        $this->order = $order;
        $this->notification = $notification;
        $this->product = $product;
    }

    public function index()
    {
        return view('order::dashboard.orders.index');
    }

    public function getAllOrders()
    {
        return view('order::dashboard.all_orders.index');
    }

    public function getCompletedOrders()
    {
        return view('order::dashboard.completed_orders.index');
    }

    public function getNotCompletedOrders()
    {
        return view('order::dashboard.not_completed_orders.index');
    }

    public function getRefundedOrders()
    {
        return view('order::dashboard.refunded_orders.index');
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

    public function create()
    {
        abort(404);
        return view('order::dashboard.orders.create');
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show($id, $flag = null)
    {
        $order = $this->order->findById($id);
        if (!$order || ($flag != $order->order_flag && $flag != 'all_orders')) {
            abort(404);
        }

        $this->order->updateUnread($id);
        $statuses = $this->status->getAll()->whereNotIn('flag', ConstantOrderStatus::BLOCK_CHANGE_STATUS_FLAGS);
        $order->allProducts = $order->orderProducts->mergeRecursive($order->orderVariations);
        // $ordersRouteName = \request()->segment(3) == 'all-orders' ? 'all_orders' : 'orders';

        return view('order::dashboard.orders.show', compact('order', 'statuses', 'flag'));
    }

    public function refundOrder(Request $request, $id)
    {
        $res = $this->order->refundOrderOperation($request, $id);

        if ($res && $res[0] == 0) {

            return Response()->json([false, $res[1]]);
        }

        return Response()->json([true, __('apps::dashboard.general.message_update_success'), 'url' => route('dashboard.orders.show', [$id, 'all_orders'])]);
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
        return redirect()->route('dashboard.orders.show', [$id, 'all_orders']);
    }

    public function update(OrderDriverRequest $request, $id)
    {
        try {
            $update = $this->order->updateOrderStatusAndDriver($request, $id);

            if ($update) {
                // if ($request['user_id']) {
                ### Start Send E-mail & Push Notification To Mobile App Users ###
                $this->sendNotificationToUser($id);
                ### End Send E-mail & Push Notification To Mobile App Users ###
                // }

                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function updateBulkOrderStatus(Request $request)
    {
        try {
            $updatedOrder = false;
            foreach ($request['ids'] as $id) {
                $updatedOrder = $this->order->updateOrderStatusAndDriver($request, $id);
                if ($updatedOrder) {

                    ### Start Send E-mail & Push Notification To Mobile App Users ###
                    $this->sendNotificationToUser($id);
                    ### End Send E-mail & Push Notification To Mobile App Users ###

                }
            }

            if ($updatedOrder) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
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

    public function printSelectedItems(Request $request)
    {
        try {
            if (isset($request['ids']) && !empty($request['ids'])) {
                $ids = explode(',', $request['ids']);
                $orders = $this->order->getSelectedOrdersById($ids);
                return view('order::dashboard.orders.print', compact('orders'));
            }
            // return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);
        } catch (\PDOException $e) {
            return redirect()->back()->withErrors($e->errorInfo[2]);
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
                'title' => __('order::dashboard.orders.notification.title'),
                'body' => __('order::dashboard.orders.notification.body') . ' - ' . $order->orderStatus->title,
                'type' => 'order',
                'id' => $order->id,
            ];

            $this->send($data, $tokens);
        }

        if ($order->user && $order->user->email) {
            // Send E-mail to order user
            Mail::to($order->user->email)
                ->send(new UpdateOrderStatusMail($order));
        }

        return true;
    }
}
