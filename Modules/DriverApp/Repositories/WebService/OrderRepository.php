<?php

namespace Modules\DriverApp\Repositories\WebService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Product;
use Modules\Order\Entities\Order;
use Modules\User\Entities\DriverState;
use Modules\User\Entities\User;
use Modules\User\Repositories\WebService\AddressRepository;
use Modules\Variation\Entities\ProductVariant;
use Modules\Vendor\Entities\Vendor;

class OrderRepository
{
    protected $user;

    public function __construct(Order $order, ProductVariant $variantPrd, Product $product, Vendor $vendor, AddressRepository $address, User $user)
    {
        $this->vendor = $vendor;
        $this->variantPrd = $variantPrd;
        $this->product = $product;
        $this->order = $order;
        $this->address = $address;
        $this->user = $user;
    }

    public function getAllByUser($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->with(['orderStatus'])->where('user_id', auth('api')->id())->orderBy($order, $sort)->get();
        return $orders;
    }

    public function getAllByDriver($order = 'id', $sort = 'desc')
    {
        $driverStates = $this->getDriverStates(auth('api')->id()) ?? [];
        $query = $this->order->with(['orderStatus' /* , 'orderProducts', 'orderVariations' */]);
        $query->whereHas('vendors', function ($query) {
            $query->where('use_app_drivers', 1);
        });

        $query = $query->where(function ($query) use ($driverStates) {
            $query->whereIn('payment_status_id', [2, 4]);
            $query->whereHas('orderStatus', function ($query) {
                $query = $query->whereIn('flag', ['new_order', 'delivered', 'received']);
            });

            if (auth('api')->user()->can('driver_access')) {
                $query = $query->where(function ($query) use ($driverStates) {
                    $query->whereHas('driver', function ($query) {
                        $query->where('user_id', auth('api')->id());
                    });
                    $query = $query->orWhere(function ($query) use ($driverStates) {
                        $query->doesntHave('driver');
                        $query->whereHas('orderAddress', function ($query) use ($driverStates) {
                            $query->whereIn('state_id', $driverStates);
                        });
                    });
                });
            }

        });

        $query = $query->orderBy($order, $sort)->get();
        return $query;
    }

    protected function getDriverStates($id)
    {
        return DriverState::where('status', 1)->where('user_id', $id)->pluck('state_id')->toArray();
    }

    public function findOrderById($id)
    {
        $query = $this->order->with(['orderStatus']);
        $query = $query->whereHas('vendors', function ($q) {
            $q->where('use_app_drivers', 1);
        });

        if (auth('api')->user()->can('driver_access')) {
            $driverStates = $this->getDriverStates(auth('api')->id()) ?? [];

            if (!empty($driverStates)) {
                $query = $query->whereDoesntHave('driver')->whereHas('orderAddress', function ($q) use ($driverStates) {
                    $q->whereIn('state_id', $driverStates);
                });
            } else {
                $query = $query->whereHas('driver', function ($q) {
                    $q->where('user_id', auth('api')->id());
                });
            }
        }
        return $query->find($id);
    }

    public function getDriverPendingOrdersCount()
    {
        $query = $this->order->whereHas('vendors', function ($q) {
            $q->where('use_app_drivers', 1);
        })->where(function ($query) {
            $query->whereHas('driver', function ($q) {
                $q->where('user_id', auth('api')->id());
            })->whereHas('orderStatus', function ($query) {
                $query = $query->where('flag', 'new_order');
            });
        });
        return $query->count();
    }

    public function findNewOrderById($id)
    {
        $query = $this->order->query();
        $query = $query->whereHas('vendors', function ($q) {
            $q->where('use_app_drivers', 1);
        });
        if (auth('api')->user()->can('driver_access')) {
            $query = $query->doesntHave('driver');
        }
        return $query->find($id);
    }

    public function findOrderByDriver($id, $driverId)
    {
        $query = $this->order->query();
        $query = $query->whereHas('vendors', function ($q) {
            $q->where('use_app_drivers', 1);
        });
        $query = $query->whereHas('driver', function ($q) use ($driverId) {
            $q->where('user_id', $driverId);
        });
        return $query->find($id);
    }

    public function findById($id)
    {
        $order = $this->order->find($id);
        return $order;
    }

    public function findByIdWithUserId($id)
    {
        return $this->order->where('user_id', auth('api')->id())->find($id);
    }

    public function create($request, $allGifts, $allCards, $allAddons, $shippingCompany, $status = false)
    {
        $orderData = $this->calculateTheOrder(
            $request,
            $allGifts['totalGiftsPrice'],
            $allCards['totalCardsPrice'],
            $allAddons['totalAddonsPrice'],
            floatval($shippingCompany['delivery_price'])
        );

        DB::beginTransaction();

        try {

            $orderCreated = $this->order->create([
                'original_subtotal' => $orderData['original_subtotal'],
                'subtotal' => $orderData['subtotal'],
                'off' => $orderData['off'],
                'shipping' => $orderData['shipping'],
                'total' => $orderData['total'],
                'total_profit' => $orderData['profit'],
                'user_id' => $orderData['user_id'],
                'order_status_id' => ($request['payment'] == 'cash') ? 3 : 4,
                'notes' => $request['notes'] ?? null,
            ]);

            $orderCreated->transactions()->create([
                'method' => $request['payment'],
                'result' => ($request['payment'] == 'cash') ? 'CASH' : null,
            ]);

            $this->createOrderProducts($orderCreated, $orderData);

            ############ START To Add Order Address ###################
            if ($request->address_type == 'unknown_address') {
                $this->createUnknownOrderAddress($orderCreated, $request);
            } elseif ($request->address_type == 'known_address') {
                $address = [
                    'mobile' => $request->address['mobile'],
                    'address' => $request->address['address'],
                    'block' => $request->address['block'],
                    'street' => $request->address['street'],
                    'building' => $request->address['building'],
                    'state_id' => $request->address['state_id'],
                ];
                $this->createOrderAddress($orderCreated, $address);
            } elseif ($request->address_type == 'selected_address') {
                // get address by id
                $address = $this->address->findByIdWithoutAuth($request->address['selected_address_id']);
                if ($address) {
                    $newAddress = [
                        'mobile' => $address['mobile'],
                        'address' => $address['address'],
                        'block' => $address['block'],
                        'street' => $address['street'],
                        'building' => $address['building'],
                        'state_id' => $address['state_id'],
                    ];
                    $this->createOrderAddress($orderCreated, $newAddress);
                } else {
                    return false;
                }

            }
            ############ END To Add Order Address ###################

            if ($orderData['vendors']) {
                $this->createOrderVendors($orderCreated, $orderData['vendors']);
            }

            if (isset($request['gift']) && !empty($request['gift'])) {
                $this->createOrderGift($orderCreated, $allGifts['gifts']);
            }

            if (isset($request['card']) && !empty($request['card'])) {
                $this->createOrderCard($orderCreated, $allCards['cards']);
            }

            if (isset($request['addons']) && !empty($request['addons'])) {
                $this->createOrderAddons($orderCreated, $allAddons['addons']);
            }

            if (isset($request['shipping_company']) && !empty($request['shipping_company'])) {
                $this->createOrderCompanies($orderCreated, $request['shipping_company'], $shippingCompany);
            }

            DB::commit();
            return $orderCreated;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createOrderProducts($orderCreated, $orderData)
    {
        foreach ($orderData['products'] as $product) {

            $prd = [
                'off' => $product['off'],
                'qty' => $product['quantity'],
                'price' => $product['original_price'],
                'sale_price' => $product['sale_price'],
                'original_total' => $product['original_total'],
                'total' => $product['total'],
                'total_profit' => $product['total_profit'],
            ];

            if ($product['product_type'] == 'variation') {
                $prd['product_variant_id'] = $product['product_id'];
                $orderProduct = $orderCreated->orderVariations()->create($prd);

                $productVariant = $this->variantPrd->with('productValues')->find($product['product_id']);

                // add product_variant_values to order variations
                if (count($productVariant->productValues) > 0) {
                    foreach ($productVariant->productValues as $k => $value) {
                        $orderProduct->orderVariantValues()->create([
                            'product_variant_value_id' => $value->id,
                        ]);
                    }
                }
            } else {
                $prd['product_id'] = $product['product_id'];
                $orderProduct = $orderCreated->orderProducts()->create($prd);
            }
        }
    }

    public function createOrderAddress($orderCreated, $address)
    {
        $orderCreated->orderAddress()->create($address);
    }

    public function createUnknownOrderAddress($orderCreated, $request)
    {
        $orderCreated->unknownOrderAddress()->create([
            'receiver_name' => $request->address['receiver_name'],
            'receiver_mobile' => $request->address['receiver_mobile'],
            'state_id' => $request->address['state_id'],
        ]);
    }

    public function updateSuccessOrder($request, $data)
    {
        $order = $this->findById($data['order_id']);

        $order->update([
            'order_status_id' => 3,
        ]);

        $order->transactions()->updateOrCreate(
            [
                'transaction_id' => $data['order_id'],
            ],
            [
                'auth' => $request['AuthorizationId'],
                'tran_id' => $request['TranID'],
                // 'result'        => $request['Result'],
                'post_date' => $request['TransactionDate'],
                'ref' => $request['ReferenceId'],
                'track_id' => $request['TrackId'],
                'payment_id' => $request['PaymentId'],
            ]
        );

        return true;
    }

    public function calculateTheOrder($request, $totalGiftsPrice = 0, $totalCardsPrice = 0, $totalAddonsPrice = 0, $deliveryCharge = 0)
    {
        $order = $this->orderProducts($request);
        $total = $order['original_subtotal'] + $deliveryCharge + $totalGiftsPrice + $totalCardsPrice + $totalAddonsPrice;

        $order['subtotal'] = $order['original_subtotal'];
        $order['shipping'] = $deliveryCharge;
        $order['total'] = $total;

        $order['user_id'] = $request['user_id'] ?? null;

        foreach ($order['vendorsModel'] as $k => $vendor) {
            $order['vendors'][$k]['id'] = $vendor->id;
            $order['vendors'][$k]['commission'] = $this->commissionFromVendor($vendor, $total);
            $order['vendors'][$k]['totalProfitCommission'] = floatval($order['vendors'][$k]['commission'] + $order['profit']);
            //            $order['vendors'][$k]['totalProfitCommission'] = number_format($order['vendors'][$k]['commission'] + $order['profit'], 3);
        }

        unset($order['vendorsModel']);

        return $order;
    }

    public function commissionFromVendor($vendor, $total)
    {
        $percentege = $vendor['commission'] ? $total * ($vendor['commission'] / 100) : 0.000;
        $fixed = $vendor['fixed_commission'] ? $vendor['fixed_commission'] : 0.000;

        return $percentege + $fixed;
    }

    public function orderAddress($request)
    {
        return [
            //            'email' => $request['address']['email'],
            //            'username' => $request['address']['username'],
            'mobile' => $request['address']['mobile'],
            'address' => $request['address']['address'],
            'block' => $request['address']['block'],
            'street' => $request['address']['street'],
            'building' => $request['address']['building'],
            'state_id' => $request['address']['state_id'],
        ];
    }

    public function orderProducts($request)
    {
        $data = [];
        $subtotal = 0.000;
        $off = 0.000;
        $price = 0.000;
        $profit = 0.000;
        $profitPrice = 0.000;
        $vendors = [];

        $request['product_id'] = array_values($request['product_id']);
        $request['qty'] = array_values($request['qty']);
        $request['product_type'] = isset($request['product_type']) ? array_values($request['product_type']) : [];

        foreach ($request['product_id'] as $key => $id) {

            if ($request['product_type'] && $request['product_type'][$key] == 'variation') {
                $prod = $this->variantPrd->with('offer')->find($id);
                $prod->vendor_id = $prod->product->vendor_id;
                $offer_column = 'product_variant_id';
                $product_type = 'variation';
            } else {
                $prod = $this->product->with('offer')->find($id);
                $offer_column = 'product_id';
                $product_type = 'product';
            }

            if ($prod) {

                $vendor = $this->vendor->find($prod->vendor_id);
                $vendorsIDs = array_column($vendors, 'id');
                if (!in_array($prod->vendor_id, $vendorsIDs)) {
                    $vendors[] = $vendor;
                }

                if ($prod->offer()->exists()) {
                    ### Offer exists
                    $offerPrice = $prod->offer->where($offer_column, $id)->active()->unexpired()->value('offer_price');
                    $offerPrice = !is_null($offerPrice) ? $offerPrice : $prod['price'];
                } else {
                    $offerPrice = $prod['price'];
                }

                $product['product_type'] = $product_type;

                $product['product_id'] = $id;
                //            $product['original_price'] = $prod['price'];
                $product['original_price'] = $offerPrice;
                //            $product['sale_price'] = $request['price'][$key];
                $product['sale_price'] = $offerPrice;
                $product['quantity'] = intval($request['qty'][$key]);
                $product['sku'] = $prod['sku'];

                $product['off'] = $product['original_price'] - $product['sale_price'];

                $product['original_total'] = $product['original_price'] * $product['quantity'];

                $product['total'] = $product['sale_price'] * $product['quantity'];
                $product['cost_price'] = $prod['cost_price'];
                $product['total_cost_price'] = $product['cost_price'] * $product['quantity'];
                $product['total_profit'] = $product['total'] - $product['total_cost_price'];

                $off += $product['off'];
                $price += $product['total'];
                $subtotal += $product['original_total'];
                $profitPrice += $product['total_cost_price'];
                $profit += $product['total_profit'];

                $data[] = $product;
            }
        }

        return [
            'original_subtotal' => $subtotal,
            'profit' => $profit,
            'off' => $off,
            'products' => $data,
            'vendorsModel' => $vendors,
        ];
    }

    public function createOrderGift($orderCreated, $gifts)
    {
        $orderCreated->orderGifts()->saveMany($gifts);
    }

    public function createOrderCard($orderCreated, $cards)
    {
        $orderCreated->orderCards()->saveMany($cards);
    }

    public function createOrderAddons($orderCreated, $addons)
    {
        $orderCreated->orderAddons()->saveMany($addons);
    }

    public function createOrderVendors($orderCreated, $vendors)
    {
        foreach ($vendors as $k => $vendor) {
            $orderCreated->vendors()->attach($vendor['id'], [
                'total_comission' => $vendor['commission'],
                'total_profit_comission' => $vendor['totalProfitCommission'],
            ]);
        }
    }

    public function createOrderCompanies($orderCreated, $companyRequest, $company)
    {
        $availabilities = [
            'day' => $companyRequest['availabilities']['day'],
            'day_code' => $companyRequest['availabilities']['day_code'],
            'full_date' => getDayByDayCode($companyRequest['availabilities']['day_code'])['full_date'],
        ];

        $data = [
            'company_id' => $company['id'],
            'availabilities' => \GuzzleHttp\json_encode($availabilities),
            'delivery' => floatval($company['delivery_price']),
            'day_code' => $companyRequest['availabilities']['day_code'] ?? null,
        ];

        if (isset($companyRequest['availabilities']['time_from']) && !empty($companyRequest['availabilities']['time_from'])) {
            $data['time_from'] = date("H:i", strtotime($companyRequest['availabilities']['time_from']));
        } else {
            $data['time_from'] = null;
        }

        if (isset($companyRequest['availabilities']['time_to']) && !empty($companyRequest['availabilities']['time_to'])) {
            $data['time_to'] = date("H:i", strtotime($companyRequest['availabilities']['time_to']));
        } else {
            $data['time_to'] = null;
        }

        $orderCreated->companies()->attach($company['id'], $data);
    }

    public function updateOrderByDriver($order, $request, $id)
    {
        $orderData = [];
        if (isset($request['accepted']) && !empty($request['accepted'])) {
            $orderData['accepted'] = $request['accepted'] == 1 ? 1 : 0;
        }

        if (isset($request['delivered']) && !empty($request['delivered'])) {
            $orderData['delivered'] = $request['delivered'] == 1 ? 1 : 0;
        }

        $orderData['user_id'] = auth('api')->id();
        $order->driver()->create($orderData);
        return true;
    }

    public function updateOrderStatus($order, $request)
    {
        $orderData = [];
        $check = false;

        if (isset($request['order_status_id']) && !empty($request['order_status_id'])) {
            $orderData['order_status_id'] = $request['order_status_id'];
        }

        if (isset($request['order_notes']) && !empty($request['order_notes'])) {
            $orderData['order_notes'] = $request['order_notes'];
        }

        if (!empty($orderData)) {
            $check = $order->update($orderData);
        }

        if ($request['user_id'] && auth('api')->user()->can('dashboard_access')) {
            $check = $order->driver()->updateOrCreate([
                'user_id' => $request['user_id'],
            ]);
        }
        return $check;
    }
}
