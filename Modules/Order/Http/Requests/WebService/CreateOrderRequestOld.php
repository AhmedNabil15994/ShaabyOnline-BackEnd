<?php

namespace Modules\Order\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Company\Repositories\WebService\CompanyRepository as Company;
use Modules\User\Repositories\WebService\AddressRepository as Address;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;

class CreateOrderRequestOld extends FormRequest
{
    protected $companyRepo;
    protected $addressRepo;
    protected $catalogRepo;

    function __construct(Company $company, Address $address, Catalog $catalog)
    {
        $this->companyRepo = $company;
        $this->addressRepo = $address;
        $this->catalogRepo = $catalog;
    }

    public function rules()
    {
        if ($this->address_type == 'guest_address') {
            $rules = [
                'address.username' => 'nullable|string',
                'address.email' => 'nullable|email',
                'address.state_id' => 'required|numeric',
                'address.mobile' => 'required|string',
//                'address.mobile' => 'required|string|min:8|max:8',
                'address.block' => 'required|string',
                'address.street' => 'required|string',
                'address.building' => 'required|string',
                'address.address' => 'nullable|string',
            ];
        } elseif ($this->address_type == 'selected_address') {
            $rules = [
                'address.selected_address_id' => 'required',
            ];
        } else {
            $rules = [
                'address_type' => 'required|in:guest_address,selected_address',
            ];
        }

        $rules['user_id'] = 'nullable|exists:users,id';
        $rules['payment'] = 'required|in:cash,online';
        $rules['shipping_company.availabilities.day_code'] = 'nullable';
        $rules['shipping_company.availabilities.day'] = 'nullable';

        return $rules;
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $messages = [
            'address_type.required' => __('order::api.address.validations.address_type.required'),
            'address_type.in' => __('order::api.address.validations.address_type.in'),
            'selected_address_id.required' => __('order::api.address.validations.selected_address_id.required'),

            'address.username.string' => __('order::api.address.validations.username.string'),
            'address.email.email' => __('order::api.address.validations.email.email'),
            'address.state_id.required' => __('order::api.address.validations.state_id.required'),
            'address.state_id.numeric' => __('order::api.address.validations.state_id.numeric'),
            'address.mobile.required' => __('order::api.address.validations.mobile.required'),
            'address.mobile.numeric' => __('order::api.address.validations.mobile.numeric'),
            'address.mobile.digits_between' => __('order::api.address.validations.mobile.digits_between'),
            'address.mobile.min' => __('order::api.address.validations.mobile.min'),
            'address.mobile.max' => __('order::api.address.validations.mobile.max'),
            'address.address.required' => __('order::api.address.validations.address.required'),
            'address.address.string' => __('order::api.address.validations.address.string'),
            'address.address.min' => __('order::api.address.validations.address.min'),
            'address.block.required' => __('order::api.address.validations.block.required'),
            'address.block.string' => __('order::api.address.validations.block.string'),
            'address.street.required' => __('order::api.address.validations.street.required'),
            'address.street.string' => __('order::api.address.validations.street.string'),
            'address.building.required' => __('order::api.address.validations.building.required'),
            'address.building.string' => __('order::api.address.validations.building.string'),

            'user_id.exists' => __('order::api.orders.validations.user_id.exists'),
            'payment.required' => __('order::api.payment.validations.required'),
            'payment.in' => __('order::api.payment.validations.in') . ' cash,online',

            'shipping_company.availabilities.day_code.required' => __('order::api.shipping_company.validations.day_code.required'),
            'shipping_company.availabilities.day.required' => __('order::api.shipping_company.validations.day.required'),
        ];

        return $messages;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (auth()->guard('api')->check() && auth()->guard('api')->user()->id != $this->user_id) {
                return $validator->errors()->add(
                    'user_id', __('order::api.orders.validations.user_id.does_not_match')
                );
            }

            // Check Address Validation
            if ($this->address_type == 'selected_address') {
                $selectedAddress = $this->addressRepo->findById($this->address['selected_address_id']);
                if (!$selectedAddress) {
                    return $validator->errors()->add(
                        'address.selected_address_id', __('order::api.address.validations.selected_address_id.not_found')
                    );
                }
            }

            ######################## START Get Default Shipping Company #######################
            $id = config('setting.other.shipping_company') ?? 0;

            if ($this->address_type == 'selected_address') {
                $stateId = $selectedAddress->state_id;
            } else {
                $stateId = $this->address['state_id'];
            }
            $row = $this->companyRepo->findByIdAndStateId($stateId, $id);
            if ($row && $row->deliveryCharge) {
                if (count($row->deliveryCharge) == 0) {
                    return $validator->errors()->add(
                        'shipping_company.is_supported', __('company::webservice.shipping_company.validation.this_area_is_not_supported')
                    );
                }
            } else {
                return $validator->errors()->add(
                    'shipping_company.is_available', __('company::webservice.shipping_company.validation.shipping_company_not_available')
                );
            }
            ######################## END Get Default Shipping Company #######################

            // check if product have variations or not
            foreach ($this->product_id as $key => $id) {
                if ($this->product_type[$key] == 'product') {
                    $prod = $this->catalogRepo->findOneProduct($id);
                } else {
                    $prod = $this->catalogRepo->findOneProductVariant($id);
                }

                if (!$prod) {
                    return $validator->errors()->add(
                        'product.not_found', __('order::api.product.form.product_id') . ': ' . $id . ' - ' . __('order::api.product.validations.not_found')
                    );
                } else {
                    // product existed
                    if ($this->product_type[$key] == 'product') {

                        // product has variations
                        if (count($prod->variants) > 0) {
                            return $validator->errors()->add(
                                'product.has_variations', __('order::api.product.validations.has_variations')
                            );
                        }

                        // check product quantity
                        if (intval($prod->qty) < intval($this->qty[$key])) {
                            return $validator->errors()->add(
                                'product.qty_exceeded', __('order::api.product.validations.qty_exceeded') . ': ' . $prod->translateOrDefault(locale())->title
                            );
                        }

                    } else {
                        // check variant product quantity
                        if (intval($prod->qty) < intval($this->qty[$key])) {
                            return $validator->errors()->add(
                                'product.qty_exceeded', __('order::api.product.validations.qty_exceeded') . ': ' . $prod->product->translateOrDefault(locale())->title
                            );
                        }
                    }
                }
            }

        });
        return true;
    }
}
