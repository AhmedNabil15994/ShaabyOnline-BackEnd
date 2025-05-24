<?php

namespace Modules\Order\Repositories\Vendor;

use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderVendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\PaymentStatus;

class OrderRepository
{
    protected $order;
    protected $orderVendor;

    function __construct(Order $order, OrderVendor $orderVendor)
    {
        $this->order = $order;
        $this->orderVendor = $orderVendor;
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order
            ->whereHas('orderStatus', function ($query) {
                $query->successOrderStatus();
            })
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            })
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
            ->groupBy('date')
            ->pluck('date');

        $ordersIncome = $this->order
            ->whereHas('orderStatus', function ($query) {
                $query->successOrderStatus();
            })
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            })
            ->select(DB::raw("sum(total) as profit"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->order
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            })
            ->select("order_status_id", DB::raw("count(id) as count"))
            ->groupBy('order_status_id')
            ->get();


        foreach ($orders as $order) {

            $status = $order->orderStatus->title;
            $order->type = $status;
        }

        $data["ordersCount"] = json_encode(array_pluck($orders, 'count'));
        $data["ordersType"] = json_encode(array_pluck($orders, 'type'));

        return $data;
    }

    public function completeOrdersOld()
    {
        $orders = $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            })->count();

        return $orders;
    }

    public function completeOrders()
    {
        $orders = $this->orderVendor->whereHas('vendor.sellers', function ($q) {
            $q->where('seller_id', auth()->user()->id);
        })->whereHas('order.orderStatus', function ($query) {
            $query->successOrderStatus();
        })->count();

        return $orders;
    }

    public function totalProfitOld()
    {
        return $this->order
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            })->whereHas('orderStatus', function ($query) {
                $query->successOrderStatus();
            })->sum('total');
    }

    public function totalProfit()
    {
        return $this->orderVendor
            ->whereHas('vendor.sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            })->whereHas('order.orderStatus', function ($query) {
                $query->successOrderStatus();
            })->sum('subtotal');
    }

    public function totalTodayProfitOld()
    {
        return $this->order->whereHas('vendors', function ($q) {
            $q->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })->whereDate("created_at", DB::raw('CURDATE()'))
            ->sum('total');
    }

    public function totalTodayProfit()
    {
        return $this->orderVendor->whereHas('vendor.sellers', function ($q) {
            $q->where('seller_id', auth()->user()->id);
        })->whereHas('order.orderStatus', function ($query) {
            $query->successOrderStatus();
        })->whereDate("created_at", DB::raw('CURDATE()'))
            ->sum('subtotal');
    }

    public function totalMonthProfitOld()
    {
        return $this->order->whereHas('vendors', function ($q) {
            $q->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })->whereMonth("created_at", date("m"))
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function totalMonthProfit()
    {
        return $this->orderVendor->whereHas('vendor.sellers', function ($q) {
            $q->where('seller_id', auth()->user()->id);
        })->whereHas('order.orderStatus', function ($query) {
            $query->successOrderStatus();
        })->whereMonth("created_at", date("m"))
            ->whereYear("created_at", date("Y"))
            ->sum('subtotal');
    }

    public function totalYearProfitOld()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function totalYearProfit()
    {
        return $this->orderVendor->whereHas('vendor.sellers', function ($q) {
            $q->where('seller_id', auth()->user()->id);
        })->whereHas('order.orderStatus', function ($query) {
            $query->successOrderStatus();
        })->whereYear("created_at", date("Y"))
            ->sum('subtotal');
    }

    public function totalProfitCommission()
    {
        return $this->orderVendor->whereHas('vendor.sellers', function ($q) {
            $q->where('seller_id', auth()->user()->id);
        })->whereHas('order.orderStatus', function ($query) {
            $query->successOrderStatus();
        })->sum('total_profit_comission');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            })->orderBy($order, $sort)->get();

        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order
            ->with([
                'orderProducts.product',
            ])
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            })
            ->withDeleted()->find($id);

        return $order;
    }

    public function getVendorProductsByOrderId($id)
    {
        $order = $this->order->with([
            'orderProducts' => function ($query) {
                $query->whereHas('product.vendor.sellers', function ($q) {
                    $q->where('seller_id', auth()->id());
                });
            },
            'orderVariations' => function ($query) {
                $query->whereHas('variant.product.vendor.sellers', function ($q) {
                    $q->where('seller_id', auth()->id());
                });
            },
        ])->whereHas('vendors', function ($q) {
            $q->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->id());
            });
        })->withDeleted()->find($id);
        return $order;
    }

    public function updateUnread($id)
    {
        $order = $this->findById($id);
        if (!$order)
            abort(404);

        $order->update([
            'unread' => true,
        ]);
    }

    public function updateStatus($request, $id)
    {
        DB::beginTransaction();
        try {
            $order = $this->findById($id);
            if (!$order)
                abort(404);

            $orderData = ['order_status_id' => $request['order_status']];
            if (isset($request['order_notes']) && !empty($request['order_notes']))
                $orderData['order_notes'] = $request['order_notes'];

            $order->update($orderData);
            $order->orderStatusesHistory()->attach([$request['order_status'] => ['user_id' => auth()->id()]]);

            if ($request['user_id']) {
                $order->driver()->delete();
                $order->driver()->updateOrCreate([
                    'user_id' => $request['user_id'],
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
        return true;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model) {
                if ($model->trashed()) :
                    $model->forceDelete();
                else :
                    $model->delete();
                endif;
            }

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

    public function customQueryTable($request, $flags = [])
    {
        $query = $this->order->with('orderAddress.state')
            ->whereHas('vendors', function ($q) {
                $q->whereHas('sellers', function ($q) {
                    $q->where('seller_id', auth()->user()->id);
                });
            });

        if (!empty($flags)) {
            $query = $query->whereHas('orderStatus', function ($query) use ($flags) {
                $query->whereIn('flag', $flags);
            });
        }

        $query = $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('orderAddress', function ($query) use ($request) {
                    $query->where('username', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhereHas('state', function ($query) use ($request) {
                        $query->where('title', '%' . $request->input('search.value') . '%');
                    });
                });
            });
        });
        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        /* if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) && $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) && $request['req']['status'] == '0')
            $query->unactive(); */

        if (isset($request['req']['vendor']) && !empty($request['req']['vendor'])) {
            $query->whereHas('vendors', function ($q) use ($request) {
                $q->where('order_vendors.vendor_id', $request['req']['vendor']);
            });
        }

        if (isset($request['req']['order_status']) && !empty($request['req']['order_status'])) {
            $query->whereHas('orderStatus', function ($q) use ($request) {
                $q->where('id', $request['req']['order_status']);
            });
        }

        if (isset($request['req']['state_id']) && !empty($request['req']['state_id'])) {
            $query->whereHas('orderAddress.state', function ($q) use ($request) {
                $q->where('id', $request['req']['state_id']);
            });
        }

        if (isset($request['req']['city_id']) && !empty($request['req']['city_id'])) {
            $query->whereHas('orderAddress.state.city', function ($q) use ($request) {
                $q->where('id', $request['req']['city_id']);
            });
        }

        if (isset($request['req']['country_id']) && !empty($request['req']['country_id'])) {
            $query->whereHas('orderAddress.state.city.country', function ($q) use ($request) {
                $q->where('id', $request['req']['country_id']);
            });
        }

        if (isset($request['req']['driver_id']) && !empty($request['req']['driver_id'])) {
            $query->whereHas('driver', function ($q) use ($request) {
                $q->where('user_id', $request['req']['driver_id']);
            });
        }

        if (isset($request['req']['payment_type']) && !empty($request['req']['payment_type'])) {
            $query->whereHas('transactions', function ($q) use ($request) {
                $q->where('method', $request['req']['payment_type']);
            });
        }

        if (isset($request['req']['payment_status']) && !empty($request['req']['payment_status'])) {
            $query->whereHas('paymentStatus', function ($q) use ($request) {
                $q->where('flag', $request['req']['payment_status']);
            });
        }

        if (isset($request['req']['user_id']) && !empty($request['req']['user_id'])) {
            $query->where('user_id', $request['req']['user_id']);
        }

        return $query;
    }

    public function refundOrderOperation($request, $id)
    {
        $order = $this->findById($id);

        DB::beginTransaction();

        try {
            $refund = $order->total;

            $refund = $this->refundItem($order, $request);

            if (is_array($refund) && $refund[0] == 0) {
                return $refund;
            }

            $order->subRefund($refund);
            $order->load("orderProducts", "orderVariations");

            if ($order->orderProducts->count() == 0 && $order->orderVariations->count() == 0) {
                $order_status_id = optional(OrderStatus::where('flag', 'refund')->first())->id ?? $order->order_status_id;
                $order->update(["order_status_id" => $order_status_id]);
                $order->orderStatusesHistory()->attach([$order_status_id => ['user_id' => auth()->id()]]);
            }

            DB::commit();

            return [1, "order" => $order->load(["user", "orderStatus"]), "refund" => $refund];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function refundItem($order, $request)
    {
        $total_refund = 0;
        foreach ($request->items as $id => $item) {
            # code...
            $query = $item["type"] == "product" ? $order->orderProducts() : $order->orderVariations();
            $product = $query->where("id", $id)->first();

            if ($product) {

                if ($product->qty < $item["qty"]) {
                    return [0, __('order::dashboard.orders.show.refund_validation.large_qty_than_item_qty', ['product' => $product->product_title . ' #' . $product->id])];
                }

                if ($product->qty > $item["qty"]) {
                    $total_refund += $product->refundOperation($item["qty"], ($request->increment_stock ? true : false));
                }
            }
        }
        return $total_refund;
    }

    public function confirmPayment($id)
    {
        $order = $this->findById($id);

        DB::beginTransaction();

        try {

            if (in_array(optional($order->paymentStatus)->flag, ['pending', 'cash'])) {
                $order->payment_status_id = optional(PaymentStatus::where('flag', 'success')->first())->id ?? $order->payment_status_id;
                $order->save();
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
