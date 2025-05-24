<?php

namespace Modules\Company\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Company\Repositories\WebService\CompanyRepository as Company;
use Modules\Company\Transformers\WebService\DeliveryCompaniesResource;

class CompanyController extends WebServiceController
{
    protected $company;

    function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getDefaultCompany(Request $request)
    {
        $id = config('setting.other.shipping_company') ?? 0;
        $row = $this->company->findByIdAndStateId($request->state_id, $id);
        if ($row) {
            $result = new DeliveryCompaniesResource($row);
            return $this->response($result);
        } else {
            return $this->response(null);
        }
    }


}
