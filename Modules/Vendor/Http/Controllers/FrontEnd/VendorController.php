<?php

namespace Modules\Vendor\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Modules\Area\Repositories\FrontEnd\StateRepository as State;
use Modules\Vendor\Http\Requests\FrontEnd\AskQuestionRequest;
use Modules\Vendor\Http\Requests\FrontEnd\PrescriptionRequest;
use Modules\Vendor\Http\Requests\FrontEnd\RateRequest;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Vendor\Repositories\FrontEnd\SectionRepository as Section;
use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;
use Modules\Vendor\Notifications\FrontEnd\AskVendordNotification;
use Modules\Vendor\Notifications\FrontEnd\PrescriptionVendordNotification;
use Modules\Vendor\Repositories\Vendor\RateRepository as Rate;
use Modules\Vendor\Traits\UploaderTrait;
use Modules\Vendor\Traits\VendorTrait;
use Notification;

class VendorController extends Controller
{
    use UploaderTrait, VendorTrait;

    protected $state;
    protected $vendor;
    protected $section;
    protected $category;
    protected $rate;

    function __construct(Vendor $vendor, State $state, Section $section, Category $category, Rate $rate)
    {
        $this->state = $state;
        $this->vendor = $vendor;
        $this->section = $section;
        $this->category = $category;
        $this->rate = $rate;
    }

    public function vendorBySection($slug)
    {
        $section = $this->section->findBySlug($slug);

        if (!$section)
            abort(404);

        $vendors = $this->vendor->getAllActiveBySectionPaginate($slug);

        if ($this->section->checkRouteLocale($section, $slug))
            return view('vendor::frontend.vendors.section', compact('section', 'vendors'));

        return redirect()->route('frontend.vendors.section', $section->slug);
    }

    public function vendorByState(Request $request)
    {
        $state = $this->state->findBySlug($request['state']);

        if (!$state)
            abort(404);

        // Save user state for later operations
        set_cookie_value('autoSaveArea', $state->id);

        $vendors = $this->vendor->getAllActiveByStatePaginate($state);

        return view('vendor::frontend.vendors.state', compact('state', 'vendors'));
    }

    public function filter(Request $request)
    {
        $additional = [];

        if (isset($request['state'])) {
            $additional['state'] = $this->state->findBySlug($request['state']);

            /*if (!$additional['state'])
                abort(404);*/
        }


        $vendors = $this->vendor->filterVendors($request, $additional);

        return view('vendor::frontend.vendors.filter', compact('vendors'));
    }

    public function show(Request $request, $slug)
    {
        $vendor = $this->vendor->findBySlug($slug);

        if (!$vendor)
            abort(404);

        $vendor->totalRates = intval($this->getVendorTotalRate($vendor->rates));
        $vendor->ratesCount = intval($this->getVendorRatesCount($vendor->rates));

        $categories = $this->category->mainCategoriesOfVendorProducts($vendor, $request);

        if (isset($request['search']) && !empty($request['search'])) {
            $categories = $categories->filter(function ($value) {
                return count($value->products) > 0;
            });
            $categories = $categories->values();
        }

//        dd($vendor->toArray(), $categories->toArray());

        if ($this->vendor->checkRouteLocale($vendor, $slug))
            return view('vendor::frontend.vendors.show', compact('vendor', 'categories'));

        return redirect()->route('frontend.vendors.show', $vendor->slug);
    }

    public function askForm($slug)
    {
        $vendor = $this->vendor->findBySlug($slug);

        if (!$vendor)
            abort(404);

        if ($this->vendor->checkRouteLocale($vendor, $slug))
            return view('vendor::frontend.vendors.ask', compact('vendor'));

        return redirect()->route('frontend.vendors.ask', $vendor->slug);
    }

    public function askQuestion(AskQuestionRequest $request, $slug)
    {
        $vendor = $this->vendor->findBySlug($slug);

        Notification::route('mail', $vendor['vendor_email'])->notify(
            (
            new AskVendordNotification($request)
            )->locale(locale()));

        return redirect()->back()->with([
            'status' => __('vendor::frontend.vendors.ask_q.alerts.send_question')
        ]);
    }

    public function prescriptionForm($slug)
    {
        $vendor = $this->vendor->findBySlug($slug);

        if (!$vendor)
            abort(404);

        if ($this->vendor->checkRouteLocale($vendor, $slug))
            return view('vendor::frontend.vendors.prescription', compact('vendor'));

        return redirect()->route('frontend.vendors.prescription', $vendor->slug);
    }

    public function sendPrescription(PrescriptionRequest $request, $slug)
    {
        $vendor = $this->vendor->findBySlug($slug);

        if (isset($request->image) && !empty($request->image)) {
            $uploadPath = $this->base64($request->image, null, 'prescriptions');
            $request->merge([
                'imagePath' => env('APP_URL') . $uploadPath,
            ]);
        } else {
            $imagePath = null;
        }


        Notification::route('mail', $vendor['vendor_email'])->notify(
            (
            new PrescriptionVendordNotification($request->all())
            )->locale(locale()));

        return redirect()->back()->with([
            'status' => __('vendor::frontend.vendors.prescription_r.alerts.send_prescription')
        ]);
    }

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
                return response()->json(["message" => __('vendor::webservice.rates.rated_successfully')], 200);
            } else
                return response()->json(["errors" => [__('vendor::webservice.rates.user_rate_before')]], 422);
        } else
            return response()->json(["errors" => [__('vendor::webservice.rates.user_not_have_order')]], 422);
    }
}
