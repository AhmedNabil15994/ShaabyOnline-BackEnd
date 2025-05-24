<?php

/*use Modules\Vendor\Entities\Vendor;
function getDefaultVendor()
{
    if (isset(config('setting.other')['is_multi_vendors']) && config('setting.other')['is_multi_vendors'] == 0) {
        $vendorId = config('setting.default_vendor');
        if ($vendorId)
            return Vendor::find($vendorId);
        else
            return null;
    } else
        return null;
}*/

return [
    'name' => 'Core',
//    'default_vendor' => getDefaultVendor(),
];
