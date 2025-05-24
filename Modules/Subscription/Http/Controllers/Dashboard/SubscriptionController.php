<?php

namespace Modules\Subscription\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Subscription\Http\Requests\Dashboard\SubscriptionRequest;
use Modules\Subscription\Transformers\Dashboard\SubscriptionResource;
use Modules\Subscription\Repositories\Dashboard\PackageRepository as Package;
use Modules\Subscription\Repositories\Dashboard\SubscriptionRepository as Subscription;

class SubscriptionController extends Controller
{

    function __construct(Subscription $subscription, Package $package)
    {
        $this->package = $package;
        $this->subscription = $subscription;
    }

    public function index()
    {
        return view('subscription::dashboard.subscriptions.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->subscription->QueryTable($request));

        $datatable['data'] = SubscriptionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('subscription::dashboard.subscriptions.create');
    }

    public function store(SubscriptionRequest $request)
    {
        try {

            $package = $this->package->findById($request['package_id']);

            $this->subscription->createHistory($request, $package);
            $create = $this->subscription->create($request, $package);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('subscription::dashboard.subscriptions.show');
    }

    public function edit($id)
    {
        $subscription = $this->subscription->findById($id);

        return view('subscription::dashboard.subscriptions.edit', compact('subscription'));
    }

    public function update(SubscriptionRequest $request, $id)
    {
        try {
            $update = $this->subscription->update($request, $id);

            if ($update) {
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
            $delete = $this->subscription->delete($id);

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
            $deleteSelected = $this->subscription->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
