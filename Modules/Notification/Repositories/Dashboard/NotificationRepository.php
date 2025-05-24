<?php

namespace Modules\Notification\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Modules\Catalog\Repositories\Dashboard\CategoryRepository as Category;
use Modules\Notification\Entities\GeneralNotification;
use Modules\User\Entities\UserFireBaseToken;
use Carbon\Carbon;

class NotificationRepository
{
    protected $token;
    protected $notification;
    protected $product;
    protected $category;

    function __construct(UserFireBaseToken $token, GeneralNotification $notification, Product $product, Category $category)
    {
        $this->token = $token;
        $this->notification = $notification;
        $this->product = $product;
        $this->category = $category;
    }

    public function getAllTokens()
    {
        return $this->token->pluck('firebase_token')->toArray();
    }

    public function getAllUserTokens($userId)
    {
        return $this->token->where('user_id', $userId)->pluck('firebase_token')->toArray();
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {

            $data = [
                'user_id' => auth()->id(),
                'title' => $request->title,
                'body' => $request->body,
            ];

            if ($request->notification_type == 'category') {
                $category = $this->category->findById($request->category_id);
                $data['notifiable_id'] = $request->category_id;
                $data['notifiable_type'] = get_class($category);
            } elseif ($request->notification_type == 'product') {
                $product = $this->product->findById($request->product_id);
                $data['notifiable_id'] = $request->product_id;
                $data['notifiable_type'] = get_class($product);
            } else {
                $data['notifiable_id'] = null;
                $data['notifiable_type'] = null;
            }
            $notification = $this->notification->create($data);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findById($id)
    {
        return $this->notification->withTrashed()->find($id);
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete();
            else:
                $model->delete();
            endif;

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->notification->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
        });
        $query = $this->filterDataTable($query, $request);
        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // FILTER
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        return $query;
    }

}
