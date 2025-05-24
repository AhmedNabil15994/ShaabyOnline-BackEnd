<?php

namespace Modules\Order\Repositories\WebService;

use Modules\Catalog\Entities\Product;
use Modules\Variation\Entities\ProductVariant;
use Modules\User\Repositories\WebService\AddressRepository;
use Modules\Company\Repositories\WebService\CompanyRepository as Company;
use Modules\Vendor\Entities\Vendor;
use Modules\Order\Entities\Order;
use Auth;
use DB;

class OrderRepositoryOld
{
    protected $vendor;
    protected $variantPrd;
    protected $product;
    protected $order;
    protected $address;
    protected $companyRepo;

    function __construct(Order $order, ProductVariant $variantPrd, Product $product, Vendor $vendor, AddressRepository $address, Company $company)
    {
        $this->vendor = $vendor;
        $this->variantPrd = $variantPrd;
        $this->product = $product;
        $this->order = $order;
        $this->address = $address;
        $this->companyRepo = $company;
    }

    public function getAllByUser($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->with(['orderStatus'])->where('user_id', auth()->id())->orderBy($order, $sort)->get();
        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->with('orderProducts')->find($id);
        return $order;
    }

    public function findByIdWithUserId($id)
    {
        $order = $this->order->where('user_id', auth()->id())->find($id);
        return $order;
    }

    public function create($request, $status = false)
    {
        if ($request->address_type == 'selected_address') {
            $selectedAddress = $this->address->findById($request->address['selected_address_id']);
            $stateId = $selectedAddress ? $selectedAddress->state_id : null;
        } else {
            $stateId = $request->address['state_id'];
        }
        $shipping_company = [];
        $id = config('setting.other.shipping_company') ?? 0;
        $row = $this->companyRepo->findByIdAndStateId($stateId, $id);
        if (count($row->deliveryCharge) > 0) {
            $shipping_company['id'] = $row->id;
            $shipping_company['delivery_price'] = $row->deliveryCharge[0]->delivery;
        }

        $orderData = $this->calculateTheOrder($request, $shipping_company ? floatval($shipping_company['delivery_price']) : 0);

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
            if ($request->address_type == 'guest_address') {
                $address = [
                    'username' => $request->address['username'] ?? null,
                    'email' => $request->address['email'] ?? null,
                    'mobile' => $request->address['mobile'],
                    'address' => $request->address['address'],
                    'block' => $request->address['block'],
                    'street' => $request->address['street'],
                    'building' => $request->address['building'],
                    'state_id' => $request->address['state_id'],
                ];
                $this->createOrderAddress($orderCreated, $address);
            } elseif ($request->address_type == 'selected_address') {
                // get address by id & user id
                $address = $this->address->findById($request->address['selected_address_id']);
                if ($address) {
                    $newAddress = [
                        'username' => $address['username'] ?? null,
                        'email' => $address['email'] ?? null,
                        'mobile' => $address['mobile'],
                        'address' => $address['address'],
                        'block' => $address['block'],
                        'street' => $address['street'],
                        'building' => $address['building'],
                        'state_id' => $address['state_id'],
                        'user_id' => $address['user_id'],
                    ];
                    $this->createOrderAddress($orderCreated, $newAddress);
                } else
                    return false;
            }
            ############ END To Add Order Address ###################

            if ($orderData['vendors']) {
                $this->createOrderVendors($orderCreated, $orderData['vendors']);
            }

            $this->createOrderCompanies($orderCreated, $request['shipping_company'] ?? [], $shipping_company);

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

                foreach ($orderCreated->orderVariations as $value) {
                    $value->variant()->decrement('qty', $value['qty']);
                }

            } else {
                $prd['product_id'] = $product['product_id'];
                $orderProduct = $orderCreated->orderProducts()->create($prd);

                foreach ($orderCreated->orderProducts as $value) {
                    $value->product()->decrement('qty', $value['qty']);
                }
            }

        }
    }

    public function createOrderAddress($orderCreated, $address)
    {
        $orderCreated->orderAddress()->create($address);
    }

    public function updateSuccessOrder($request, $data)
    {
        $order = $this->findById($data['order_id']);

        $order->update([
            'order_status_id' => 3,
        ]);

        $order->transactions()->updateOrCreate(
            [
                'transaction_id' => $data['order_id']
            ],
            [
                'auth' => $request['AuthorizationId'],
                'tran_id' => $request['TranID'],
                // 'result'        => $request['Result'],
                'post_date' => $request['TransactionDate'],
                'ref' => $request['ReferenceId'],
                'track_id' => $request['TrackId'],
                'payment_id' => $request['PaymentId'],
            ]);

        return true;
    }

    public function updateFailedOrder($request)
    {
        $order = $this->findById($request['order_id']);
        if (!$order)
            return false;

        $this->updateQtyOfProduct($order);
        $order->update([
            'order_status_id' => 4,
            'increment_qty' => true,
        ]);

        return true;
    }

    public function calculateTheOrder($request, $deliveryCharge = 0)
    {
        $order = $this->orderProducts($request);
        $total = $order['original_subtotal'] + $deliveryCharge;

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
            'email' => $request['address']['email'] ?? null,
            'username' => $request['address']['username'] ?? null,
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
                $prod = $this->variantPrd->with('product', 'offer')->find($id);
                $prod->vendor_id = $prod->product->vendor_id;
                $offer_column = 'product_variant_id';
                $product_type = 'variation';
                $vendor = $this->vendor->find($prod->product->vendor_id);
            } else {
                $prod = $this->product->with('offer')->find($id);
                $offer_column = 'product_id';
                $product_type = 'product';
                $vendor = $this->vendor->find($prod->vendor_id);
            }

            if ($prod) {

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
        $data = [
            'company_id' => count($company) > 0 ? $company['id'] : null,
            'delivery' => count($company) > 0 ? floatval($company['delivery_price']) : 0,
        ];

        if (count($companyRequest) > 0) {
            $availabilities = [
                'day' => $companyRequest['availabilities']['day'],
                'day_code' => $companyRequest['availabilities']['day_code'],
                'full_date' => getDayByDayCode($companyRequest['availabilities']['day_code'])['full_date'],
            ];

            $data['availabilities'] = \GuzzleHttp\json_encode($availabilities);
        }

        $orderCreated->companies()->attach($company['id'], $data);
    }

    public function updateQtyOfProduct($order)
    {
        if ($order->increment_qty != true) {

            foreach ($order->orderProducts as $value) {
                $value->product()->increment('qty', $value['qty']);
            }

            foreach ($order->orderVariations as $value) {
                $value->variant()->increment('qty', $value['qty']);
            }

        }
    }

}
