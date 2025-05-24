<?php

namespace Modules\Notification\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notification\Transformers\Dashboard\NotificationResource;
use Modules\Core\Traits\DataTable;
use Modules\Notification\Http\Requests\Dashboard\NotificationRequest;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;

class NotificationController extends Controller
{
    use SendNotification;

    protected $notification;

    function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function index()
    {
        return view('notification::dashboard.notifications.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->notification->QueryTable($request));
        $datatable['data'] = NotificationResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function notifyForm()
    {
        return view('notification::dashboard.notifications.create');
    }

    public function push_notification(NotificationRequest $request)
    {
        try {
            $notification = $this->notification->create($request);
            $tokens = $this->notification->getAllTokens();

            if (count($tokens) > 0) {
                $data = [
                    'title' => $request['title'],
                    'body' => $request['body'],
                ];

                if ($request->notification_type == 'category') {
                    $data['type'] = 'category';
                    $data['id'] = $request->category_id;
                } elseif ($request->notification_type == 'product') {
                    $data['type'] = 'product';
                    $data['id'] = $request->product_id;
                } else {
                    $data['type'] = 'general';
                    $data['id'] = null;
                }

                $this->send($data, $tokens);

            }
            /*else {
                return Response()->json([false, __('notification::dashboard.notifications.general.no_tokens')]);
            }*/

            return Response()->json([true, __('notification::dashboard.notifications.general.message_sent_success')]);

        } catch (\Exception $e) {
            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        }

    }

    public function destroy($id)
    {
        try {
            $delete = $this->notification->delete($id);

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
            $deleteSelected = $this->notification->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}
