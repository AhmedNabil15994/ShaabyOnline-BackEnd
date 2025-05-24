<?php

namespace Modules\Vendor\Http\Controllers\WebService;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Vendor\Http\Requests\WebService\RateRequest;
use Modules\Vendor\Traits\UploaderTrait;
use Modules\Vendor\Transformers\WebService\DeliveryCompaniesResource;
use Modules\Vendor\Transformers\WebService\SectionResource;
use Modules\Vendor\Transformers\WebService\VendorResource;
use Modules\Vendor\Transformers\WebService\DeliveryChargeResource;
use Modules\Vendor\Repositories\WebService\VendorRepository as Vendor;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;
use Modules\Company\Repositories\WebService\CompanyRepository as CompanyRepo;
use Modules\Vendor\Repositories\Vendor\RateRepository as Rate;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Vendor\Transformers\WebService\CategoryResource;
use Notification;

class VendorController extends WebServiceController
{
    use UploaderTrait;

    protected $vendor;
    protected $rate;
    protected $catalog;
    protected $company;

    function __construct(Vendor $vendor, Rate $rate, Catalog $catalog, CompanyRepo $company)
    {
        $this->vendor = $vendor;
        $this->rate = $rate;
        $this->catalog = $catalog;
        $this->company = $company;
    }

    public function sections()
    {
        $sections = $this->vendor->getAllSections();
        return $this->response(SectionResource::collection($sections));
    }

    public function getCategories(Request $request)
    {
        $items = $this->vendor->getCategories($request);

        if ($request->response_type == 'paginated')
            return $this->responsePagination(CategoryResource::collection($items));
        else
            return $this->response(CategoryResource::collection($items));
    }

    public function vendors(Request $request)
    {
        $vendors = $this->vendor->getAllVendors($request);
        return $this->response(VendorResource::collection($vendors));
    }

    public function getVendorById(Request $request)
    {
        $vendor = $this->vendor->getOneVendor($request);
        if ($vendor) {
            $products = $this->catalog->getProductsByVendor($vendor->id);
            $request->request->add(['products' => $products]);
            return $this->response(new VendorResource($vendor));
        } else
            return $this->response(null);
    }

    /* public function deliveryCharge(Request $request)
    {
        $charge = $this->vendor->getDeliveryChargesByVendorByState($request);

        if (!$charge)
            return $this->response([]);

        return $this->response(new DeliveryChargeResource($charge));
    } */

    public function vendorRate(RateRequest $request)
    {
        $order = $this->rate->findOrderByIdWithUserId($request->order_id);
        if ($order) {
            $rate = $this->rate->checkUserRate($request->order_id);
            if (!$rate) {
                $request->merge([
                    'vendor_id' => $order->vendor_id,
                ]);
                $createdRate = $this->rate->create($request);
                return $this->response([]);
            } else
                return $this->error(__('vendor::webservice.rates.user_rate_before'));
        } else
            return $this->error(__('vendor::webservice.rates.user_not_have_order'));
    }

    public function getVendorDeliveryCompanies(Request $request, $id)
    {
        $vendor = $this->vendor->findVendorByIdAndStateId($id, $request->state_id);
        if ($vendor) {
            $result['companies'] = DeliveryCompaniesResource::collection($vendor->companies);
            $result['vendor_fixed_delivery'] = $vendor->fixed_delivery;
            return $this->response($result);
        } else {
            return $this->error(__('vendor::webservice.companies.vendor_not_found_with_this_state'), null);
        }
    }

    public function getVendorDeliveryTimes(Request $request)
    {
        $userToken = $request->user_token ?? null;
        if (is_null($request->user_token)) {
            return $this->error(__('apps::frontend.general.user_token_not_found'), [], 422);
        }

        if (config('setting.other.select_shipping_provider') == 'shipping_company') {
            $companyId = config('setting.other.shipping_company') ?? 0;
            $deliveryProvider = $this->company->findById($companyId, ['deliveryTimes']);
            $errorMsg = __('vendor::webservice.vendors.company_not_in_cart');
        } else {
            $vendorId = getCartContent($userToken)->first()->attributes['vendor_id'] ?? null;
            $deliveryProvider = $this->vendor->findById($vendorId, ['deliveryTimes']);
            $errorMsg = __('vendor::webservice.vendors.vendor_not_in_cart');
        }

        $response = [];

        if ($deliveryProvider && getCartContent($userToken)->count() > 0) {
            $response['supported_types'] = $deliveryProvider->delivery_time_types;
            if (!empty($deliveryProvider->delivery_time_types)) {
                foreach ($deliveryProvider->delivery_time_types as $key => $value) {
                    if ($value == 'schedule') {
                        $buildDays = [];
                        if ($deliveryProvider->deliveryTimes) {

                            $startDate = Carbon::today()->format('Y-m-d');
                            $endDate = Carbon::today()->addDays(6)->format('Y-m-d');
                            $period = CarbonPeriod::create($startDate, $endDate);

                            foreach ($period as $index => $date) {
                                $shortDay = Str::lower($date->format('D'));
                                $deliveryTimesDays = array_column($deliveryProvider->deliveryTimes->toArray() ?? [], 'day_code');
                                if (in_array($shortDay, $deliveryTimesDays)) {
                                    $vendorDeliveryTime = $deliveryProvider->deliveryTimes->where('day_code', $shortDay)->first();
                                    $customTime = [
                                        'date' => $date->format('Y-m-d'),
                                        'day_code' => $shortDay,
                                        'day_name' => __('company::dashboard.companies.availabilities.days.' . $shortDay),
                                    ];
                                    if ($vendorDeliveryTime->is_full_day == 1) {
                                        $customTime['times'] = [
                                            ["time_from" => "12:00 AM", "time_to" => "11:00 PM"]
                                        ];
                                        $buildDays[] = $customTime;
                                    } else {
                                        $customTime['times'] = $vendorDeliveryTime->custom_times;
                                        $buildDays[] = $customTime;
                                    }
                                }
                            }

                            $response['data'][$value] = $buildDays;
                        }
                    } else {
                        $response['data'][$value] = $deliveryProvider->direct_delivery_message ?? null;
                    }
                }
            }
            return $this->response($response);
        } else {
            return $this->error($errorMsg, null);
        }
    }
}
