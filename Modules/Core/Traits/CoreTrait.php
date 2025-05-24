<?php

namespace Modules\Core\Traits;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

trait CoreTrait
{

    public function removeEmptyValuesFromArray($items)
    {
        return collect($items)->filter(function ($value, $key) {
            return $value != null && $value != '';
        })->all();
    }

    public function uploadImage($imgPath, $img)
    {
        $imgName = $img->hashName();
        $img->move($imgPath, $imgName);
        return $imgName;

        /*$imgName = $img->hashName();
        $ImageUpload = \Image::make($img);
        $ImageUpload->save($imgPath . '/' . $imgName);
        return $imgName;*/
    }

    public function buildOrderAddonsArray($orderAddons)
    {
        $result = [];
        $addonsData = $orderAddons['data'] ?? [];
        $addonsPriceObject = $orderAddons['addonsPriceObject'] ?? [];
        if (!empty($addonsData)) {
            foreach ($addonsData as $key => $value) {
                $result[$key]['addon_title'] = getAddonsTitle($value['id']);
                foreach ($value['options'] as $i => $option) {
                    $result[$key]['addon_options'][$i]['title'] = getAddonsOptionTitle($option);
                    $optionPrice = collect($addonsPriceObject)->where('id', $option)->first();
                    $result[$key]['addon_options'][$i]['price'] = $optionPrice ? ($optionPrice['amount'] ?? null) : null;
                }
            }
        }
        return $result;
    }

    public function uploadVariantImage($img)
    {
        $imgName = $img->hashName();
        $img->storeAs('products', $imgName, 'public_uploads');
        return $imgName;
    }

    public function buildDeliveryTimes($deliveryProvider)
    {
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
        return $response;
    }

    public function vendorOfProductQueryCondition($query, $stateId = null, $vendorId = null)
    {
        return $query->whereHas('vendor', function ($query) use (&$stateId, &$vendorId) {
            $query->active();

            $query = $query->when(!is_null($vendorId), function ($query) use (&$vendorId) {
                return $query->where('id', $vendorId);
            });

            $query = $query->when(config('setting.other.enable_subscriptions') == 1, function ($query) {
                return $query->whereHas('subbscription', function ($query) {
                    $query->active()->unexpired()->started();
                });
            });

            $query = $query->when(config('setting.other.select_shipping_provider') == 'vendor_delivery' && !is_null($stateId), function ($query) use (&$stateId) {
                return $query->whereHas('deliveryCharge', function ($query) use (&$stateId) {
                    $query->where('state_id', $stateId);
                });
            });
        });
    }
}
