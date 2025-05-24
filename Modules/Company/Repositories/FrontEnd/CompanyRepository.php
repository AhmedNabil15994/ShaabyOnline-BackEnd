<?php

namespace Modules\Company\Repositories\FrontEnd;

use Modules\Company\Entities\Company;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\SyncRelationModel;

class CompanyRepository
{
    use SyncRelationModel;

    protected $company;

    function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function findById($id, $with = [])
    {
        return $this->company->with($with)->find($id);
    }

    public function findByIdAndStateId($request, $id)
    {
        return $this->company->with(['deliveryCharge' => function ($query) use ($request) {
            $query->where('state_id', $request->state_id);
        }, 'availabilities'])->find($id);
    }

}
