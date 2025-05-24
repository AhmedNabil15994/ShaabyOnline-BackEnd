<?php

namespace Modules\Report\Repositories\Dashboard;

use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\OrderProduct;
use Modules\Order\Entities\OrderVariantProduct;

class ReportRepository
{
    public function __construct()
    {
    }

    public function productSales($request)
    {
        $type = "";
        if (isset($request['req']['type']) && $request['req']['type'] != '') {
            $type = $request['req']['type'];
        }
        $locale = locale();
        $variatint = DB::table("order_variant_products")->select(
            DB::raw(
                "JSON_UNQUOTE(JSON_EXTRACT(products.title, '$.$locale') )as title  ,
                                    products.id  as vendor_id    ,
                                    products.qty  as product_stock    ,
                                    \"variant\" as type ,
                                    order_variant_products.id  as id ,
                                    order_variant_products.qty  as qty ,
                                    order_variant_products.total  as total ,
                                    order_variant_products.price  as price ,
                                    order_variant_products.sale_price  as sale_price ,
                                    order_variant_products.original_total  as original_total ,
                                    order_variant_products.total_profit  as total_profit ,
                                    order_variant_products.created_at  as created_at  ,
                                    order_variant_products.order_id as order_id ,
                                    product_variants.sku  as sku ,
                                    JSON_UNQUOTE(JSON_EXTRACT(vendors.title, '$.$locale') )as vendor_title
                            "
            )
        )
            ->join("product_variants", "order_variant_products.product_variant_id", "=", "product_variants.id")
            // ->join("orders","order_variant_products.order_id", "=", "orders.id")
            ->join("products", "products.id", "=", "product_variants.product_id")
            ->join("vendors", "products.vendor_id", "=", "vendors.id");


        $variatint = $this->filterDateTableDate($variatint, "order_variant_products", $request);
        $variatint = $this->filterDateTableVendor($variatint, "products.vendor_id", $request);
        $variatint = $this->searchProductNameDaTable($variatint, $request);

        if ($type == "variant") {
            return $variatint;
        }

        $products = DB::table("order_products")->select(
            DB::raw(
                "JSON_UNQUOTE(JSON_EXTRACT(products.title, '$.$locale')) as title  ,
                                    products.id  as vendor_id    ,
                                    products.qty  as product_stock    ,
                                    \"product\" as type ,
                                    order_products.id  as id ,
                                    order_products.qty  as qty ,
                                    order_products.total  as total ,
                                    order_products.price  as price ,
                                    order_products.sale_price  as sale_price ,
                                    order_products.original_total  as original_total ,
                                    order_products.total_profit  as total_profit ,
                                    order_products.created_at  as created_at  ,
                                    order_products.order_id as order_id ,
                                    products.sku  as sku ,
                                    JSON_UNQUOTE(JSON_EXTRACT(vendors.title, '$.$locale')) as vendor_title
                            "
            )
        )
            ->join("products", "products.id", "=", "order_products.product_id")
            ->join("vendors", "products.vendor_id", "=", "vendors.id");


        $products = $this->filterDateTableDate($products, "order_products", $request);
        $products = $this->filterDateTableVendor($products, "products.vendor_id", $request);
        $products = $this->searchProductNameDaTable($products, $request);
        $products->when($type == "", function ($query) use ($variatint) {
            $query->union($variatint);
        });
        return $products;
    }

    public function productRefunSql($request)
    {
        $type = "";
        if (isset($request['req']['type']) && $request['req']['type'] != '') {
            $type = $request['req']['type'];
        }
        $variatint = DB::table("order_refund_items")->select(
            DB::raw(
                "product_translations.title as title  ,
                                    \"variant\" as type ,
                                    order_refund_items.id  as id ,
                                    order_refund_items.qty  as qty ,
                                    order_refund_items.total  as total ,
                                    order_variant_products.price  as price ,
                                    order_variant_products.created_at  as created_at  ,
                                    order_variant_products.order_id as order_id ,
                                    product_variants.sku  as sku ,
                                    vendor_translations.title as vendor_title
                            "
            )
        )
            ->join("order_variant_products", function ($join) {
                $join->on("order_variant_products.id", "=", "item_id")
                    ->where("item_type", OrderVariantProduct::class);
            })
            ->join("product_variants", "order_variant_products.product_variant_id", "=", "product_variants.id")
            // ->join("orders","order_variant_products.order_id", "=", "orders.id")
            ->join("products", "products.id", "=", "product_variants.product_id")
            ->join("vendors", "products.vendor_id", "=", "vendors.id")
            ->join("product_translations", function ($join) use ($request) {
                $join->on("products.id", "=", "product_translations.product_id")
                    ->where("product_translations.locale", locale());
            })
            ->join("vendor_translations", function ($join) use ($request) {
                $join->on("vendors.id", "=", "vendor_translations.vendor_id")
                    ->where("vendor_translations.locale", locale());
            });

        $variatint = $this->filterDateTableDate($variatint, "order_refund_items", $request);
        $variatint = $this->filterDateTableVendor($variatint, "products.vendor_id", $request);
        $variatint = $this->searchProductNameDaTable($variatint, $request);


        if ($type == "variant") {
            return $variatint;
        }

        $products = DB::table("order_refund_items")->select(
            DB::raw(
                "product_translations.title as title  ,
                                    \"product\" as type ,
                                    order_refund_items.id  as id ,
                                    order_refund_items.qty  as qty ,
                                    order_refund_items.total  as total ,
                                    order_products.price  as price ,
                                    order_products.created_at  as created_at  ,
                                    order_products.order_id as order_id ,
                                    products.sku  as sku ,
                                    vendor_translations.title as vendor_title
                            "
            )
        )
            ->join("order_products", function ($join) {
                $join->on("order_products.id", "=", "item_id")
                    ->where("item_type", OrderProduct::class);
            })
            ->join("products", "products.id", "=", "order_products.product_id")
            ->join("vendors", "products.vendor_id", "=", "vendors.id")
            ->join("product_translations", function ($join) use ($request) {
                $join->on("products.id", "=", "product_translations.product_id")
                    ->where("product_translations.locale", locale());
            })
            ->join("vendor_translations", function ($join) use ($request) {
                $join->on("vendors.id", "=", "vendor_translations.vendor_id")
                    ->where("vendor_translations.locale", locale());
            });

        $products = $this->filterDateTableDate($products, "order_products", $request);
        $products = $this->filterDateTableVendor($products, "products.vendor_id", $request);
        $products = $this->searchProductNameDaTable($products, $request);
        $products->when($type == "", function ($query) use ($variatint) {
            $query->union($variatint);
        });
        return $products;
    }

    public function filterDateTableDate($query, $table, $request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate($table . '.created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate($table . '.created_at', '<=', $request['req']['to']);
        }

        return $query;
    }

    public function searchProductNameDaTable($query, $request)
    {
        // Search Categories by Created Dates
        $query->when($request->input('search.value'), function ($query) use ($request) {
            $query->where('products.title', 'like', '%' . $request->input('search.value') . '%');
        });


        return $query;
    }

    public function searchBranchIdDatatable($query, $request, $colum = "orders.branch_id")
    {
        // Search Categories by Created Dates
        if (isset($request['req']['branch_id']) && $request['req']['branch_id'] != '') {
            $query->where($colum, '=', $request['req']['branch_id']);
        }
        return $query;
    }

    public function searchFromCashierDatatable($query, $request, $colum = "orders.from_cashier")
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from_cashier']) && $request['req']['from_cashier'] != '') {
            $query->where($colum, '=', $request['req']['from_cashier']);
        }
        return $query;
    }

    public function searchVendorNameDaTable($query, $request)
    {
        // Search Categories by Created Dates
        $query->when($request->input('search.value'), function ($query) use ($request) {
            $query->where('vendors.title', 'like', '%' . $request->input('search.value') . '%');
        });


        return $query;
    }

    public function filterDateTableVendor($query, $columWithTable, $request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['vendor_id']) && $request['req']['vendor_id'] != '') {
            $query->where($columWithTable, '=', $request['req']['vendor_id']);
        }


        return $query;
    }

    /*public function refundSales($request)
    {
        $refund = OrderRefundItem::whereHasMorph("item", ["*"])->with([
            "item" => function ($morphTo) {
                $morphTo->morphWith([OrderProduct::class => ['product.vendor']])
                    ->morphWith([OrderVariantProduct::class => ['variant.product.vendor']]);
            }

        ])
            ->when($request->input('req.vendor_id'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query
                            ->whereHasMorph("item", [OrderProduct::class], function ($query) use ($request) {
                                $query->whereHas("product", function ($query) use ($request) {
                                    $query->where("vendor_id", $request->input('req.vendor_id'));
                                });
                            })
                            ->orWhereHasMorph("item", [OrderVariantProduct::class], function ($query) use ($request) {
                                $query->whereHas("variant.product", function ($query) use ($request) {
                                    $query->where("vendor_id", $request->input('req.vendor_id'));
                                });
                            });;
                    });
                });
            })
            ->when($request->input('search.value'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query
                            ->whereHasMorph("item", [OrderProduct::class], function ($query) use ($request) {
                                $query->whereHas("product", function ($query) use ($request) {
                                    $query->where("order_id", 'like', '%' . $request->input('search.value') . '%');
                                })
                                    ->orWhereHas("product.translations", function ($query) use ($request) {
                                        $query->where("title", 'like', '%' . $request->input('search.value') . '%');
                                    });
                            })
                            ->orWhereHasMorph("item", [OrderVariantProduct::class], function ($query) use ($request) {
                                $query->whereHas("variant.product", function ($query) use ($request) {
                                    $query->where("order_id", 'like', '%' . $request->input('search.value') . '%');
                                })
                                    ->orWhereHas("variant.product.translations", function ($query) use ($request) {
                                        $query->where("title", 'like', '%' . $request->input('search.value') . '%');
                                    });
                            });;
                    });
                });
            })
            ->when($request->input('req.type'), function ($query) use ($request) {
                $request->input('req.type') == "product" ? $query->orderProduct() : $query->orderVariantProduct();
            });

        $refund = $this->filterDateTableDate($refund, "order_refund_items", $request);
        return $refund;
    }*/


    public function orderSales($request)
    {
        $order = Order::whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->with(["user", "cashier", "transactions"])
            ->withCount(["vendors", "orderProducts", "orderVariations"])
            ->when($request->input('search.value'), function ($query) use ($request) {
                $query->where('orders.id', 'like', '%' . $request->input('search.value') . '%');
            })
            ->when($request->input('req.vendor_id'), function ($query) use ($request) {
                $query->whereHas("vendors", function ($query) use ($request) {
                    $query->where("vendors.id", $request->input('req.vendor_id'));
                });
            });

        $order = $this->filterDateTableDate($order, "orders", $request);
        return $order;
    }

    public function orderSalesSql($request)
    {
        $order = DB::table("orders")
            ->select(
                DB::raw(
                    "
                                orders.total            as total ,
                                orders.shipping         as shipping ,
                                ( orders.original_subtotal - orders.subtotal ) as discount ,
                                orders.subtotal         as subtotal ,
                                transactions.method     as transactions_id ,
                                users.name              as user_id ,
                                orders.created_at       as created_at ,
                                orders.id               as id
                    "
                ),
                DB::raw(
                    " ( IFNULL(
                                    (SELECT count(order_vendors.id) FROM order_vendors
                                        WHERE orders.id = order_vendors.order_id

                                        GROUP BY order_vendors.order_id
                                    )
                            , 0)) as vendors_count"
                ),
                DB::raw("
                                ( IFNULL(
                                    (SELECT SUM(order_products.qty) FROM order_products
                                        WHERE orders.id = order_products.order_id
                                        GROUP BY order_products.order_id
                                    )
                            , 0) +  IFNULL(
                                (
                                    SELECT SUM(order_variant_products.qty) FROM order_variant_products
                                    WHERE orders.id = order_variant_products.order_id
                                    GROUP BY order_variant_products.order_id
                                )
                                , 0)
                                ) as qty
                            ")
            )
            ->distinct('order_vendors.order_id')
            ->join("users", "users.id", "=", "orders.user_id")
            ->join("order_vendors", "order_vendors.order_id", "=", "orders.id")
            ->join("order_statuses", function ($join) {
                $join->on("order_statuses.id", "=", "orders.order_status_id");
                //                    ->where("code", 3);
            })
            ->join("payment_statuses", function ($join) {
                $join->on("payment_statuses.id", "=", "orders.payment_status_id")
                    ->where("payment_statuses.flag", 'success');
            })
            ->join("transactions", function ($join) {
                $join->on("transactions.transaction_id", "orders.id")
                    ->where("transactions.transaction_type", Order::class);
            })
            ->when($request->input('search.value'), function ($query) use ($request) {
                $query->where('orders.id', 'like', '%' . $request->input('search.value') . '%');
            });
        $order = $this->filterDateTableVendor($order, "order_vendors.vendor_id", $request);
        return $order;
    }

    public function orderRefund($request)
    {
        $order = Order::whereHas('orderStatus', function ($query) {
            $query->refundOrder();
        })
            ->with(["user", "cashier", "transactions"])
            ->withCount([
                "vendors", "productRefunds as products_refund_qty" => function ($query) {
                    return $query->select(DB::raw("IFNULL(sum(order_refund_items.qty), 0)"));
                },
                "variationsRefunds as variations_refund_qty" => function ($query) {
                    return $query->select(DB::raw("IFNULL(sum(order_refund_items.qty), 0)"));
                }

            ])
            ->when($request->input('search.value'), function ($query) use ($request) {
                $query->where('orders.id', 'like', '%' . $request->input('search.value') . '%');
            })
            ->when($request->input('req.vendor_id'), function ($query) use ($request) {
                $query->whereHas("vendors", function ($query) use ($request) {
                    $query->where("vendors.id", $request->input('req.vendor_id'));
                });
            })
            ->when($request->input('req.cashier_id'), function ($query) use ($request) {
                $query->where("cashier_id", $request->input('req.cashier_id'));
            });

        $order = $this->filterDateTableDate($order, "orders", $request);


        return $order;
    }

    public function productStock($request)
    {
        $type = "";
        if (isset($request['req']['type']) && $request['req']['type'] != '') {
            $type = $request['req']['type'];
        }

        $locale = locale();
        $products = DB::table("products")
            ->select(
                DB::raw(
                    "                JSON_UNQUOTE(JSON_EXTRACT(products.title, '$.$locale')) as title  ,
                                     products.id                as id     ,
                                     products.price             as price  ,
                                     products.created_at        as created_at,
                                     JSON_UNQUOTE(JSON_EXTRACT(vendors.title, '$.$locale'))  as vendor_title
                            "
                ),
                DB::raw(
                    " ( IFNULL(
                                        (SELECT sum(product_variants.qty) FROM product_variants
                                            WHERE products.id = product_variants.product_id
                                            GROUP BY product_variants.product_id
                                        )
                                , products.qty)) as qty"
                ),
                DB::raw(
                    " ( IF(
                                    (SELECT count(product_variants.id) FROM product_variants
                                        WHERE products.id = product_variants.product_id
                                        GROUP BY product_variants.product_id
                                    ) > 0
                                    , 'variant', 'product')) as type"
                ),
                DB::raw("
                                        ( IFNULL(
                                            (SELECT SUM(order_products.qty) FROM order_products
                                                WHERE products.id = order_products.product_id
                                                GROUP BY order_products.product_id
                                            )
                                    , 0) +  IFNULL(
                                        (
                                            SELECT SUM(order_variant_products.qty) FROM order_variant_products
                                            join product_variants
                                            on product_variants.id   = order_variant_products.product_variant_id
                                            WHERE products.id = product_variants.product_id
                                            GROUP BY product_variants.product_id
                                        )
                                        , 0)
                                        ) as total
                                ")
            )
            ->join("vendors", "vendors.id", "=", "products.vendor_id")


            ->when($type == "variant", function ($query) {
                $query->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('product_variants')
                        ->whereColumn('products.id', 'product_variants.product_id');
                });
            })
            ->when($type == "product", function ($query) {
                $query->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('product_variants')
                        ->whereColumn('products.id', 'product_variants.product_id');
                });
            });

        $products = $this->filterDateTableDate($products, "products", $request);
        $products = $this->searchProductNameDaTable($products, $request);
        $products = $this->filterDateTableVendor($products, "products.vendor_id", $request);

        return $products;
    }

    public function vendors($request)
    {
        $locale = locale();
        $withTotalCount = " ( IFNULL(
                    (SELECT sum(order_vendors.subtotal) FROM order_vendors
                        INNER JOIN orders ON order_vendors.order_id = orders.id
                        WHERE
                         vendors.id = order_vendors.vendor_id

                         #OTHER_QUERY
                        GROUP BY order_vendors.vendor_id
                    )
            , 0)) as total";


        /*$withRefundCount = "
                ( IFNULL(
                    (SELECT SUM(order_refund_items.qty) FROM order_refund_items
                        INNER JOIN order_products ON order_products.id = order_refund_items.item_id
                        and order_refund_items.item_type = '" . addslashes(OrderProduct::class) . "'
                        INNER JOIN products ON order_products.product_id = products.id
                        INNER JOIN orders ON order_products.order_id = orders.id
                        WHERE
                            vendors.id = products.vendor_id

                            #OTHER_QUERY

                        GROUP BY products.vendor_id
                    )
            , 0) +  IFNULL(
                (
                    (SELECT SUM(order_refund_items.qty) FROM order_refund_items
                        INNER JOIN order_variant_products ON order_variant_products.id = order_refund_items.item_id
                        and order_refund_items.item_type = '" . addslashes(OrderVariantProduct::class) . "'
                        INNER JOIN product_variants ON product_variants.id = order_variant_products.product_variant_id
                        INNER JOIN products ON product_variants.product_id = products.id
                        INNER JOIN orders ON order_variant_products.order_id = orders.id
                        WHERE
                             vendors.id = products.vendor_id

                             #OTHER_QUERY

                        GROUP BY products.vendor_id
                    )
                )
                , 0)
                ) as total_refund
        ";*/
        $defultFilterTotal = "
                            and MONTH(orders.created_at) = MONTH(CURRENT_DATE()) and
                            YEAR(orders.created_at) = YEAR(CURRENT_DATE())";

        if ($request->input('req.from') || $request->input('req.to')) {
            $defultFilterTotal = "";
            if ($request->input('req.from')) {
                $defultFilterTotal .= " and DATE(orders.created_at) >= '" . $request->input('req.from') . "'";
            }
            if ($request->input('req.to')) {
                $defultFilterTotal .= " and DATE(orders.created_at) <= '" . $request->input('req.to') . "'";
            }
        }
        $withTotalCount = str_replace("#OTHER_QUERY", $defultFilterTotal, $withTotalCount);
        //        $withRefundCount = str_replace("#OTHER_QUERY", $defultFilterTotal, $withRefundCount);

        $vendors = DB::table("vendors")
            ->select(
                DB::raw("
                                vendors.id                 as id ,
                                JSON_UNQUOTE(JSON_EXTRACT(vendors.title, '$.$locale')) as title  ,
                                vendors.created_at         as created_at
                             "),
                DB::raw($withTotalCount),
                //                DB::raw($withRefundCount),
            );

        $vendors = $this->searchVendorNameDaTable($vendors, $request);
        return $vendors;
    }
}
