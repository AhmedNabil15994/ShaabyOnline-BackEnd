<?php

namespace Modules\User\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\User\Transformers\WebService\UserAddressResource;
use Modules\User\Http\Requests\WebService\UpdateAddressRequest;
use Modules\User\Repositories\WebService\AddressRepository as Address;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class UserAddressController extends WebServiceController
{
    protected $address;

    function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function list()
    {
        $address = $this->address->getAllByUsrId();
        return $this->response(UserAddressResource::collection($address));
    }

    public function edit(Request $request, $id)
    {
        $address = $this->address->findById($id);
        if ($address)
            return $this->response(new UserAddressResource($address));
        else
            return $this->error(__('user::webservice.address.errors.address_not_found'));
    }

    public function getAddressById($id)
    {
        $address = $this->address->findById($id);
        if ($address)
            return $this->response(new UserAddressResource($address));
        else
            return $this->error(__('user::webservice.address.errors.address_not_found'));
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $address = $this->address->findById($id);
        if ($address) {
            $this->address->update($request, $address);
            $address = $this->address->findById($id);
            return $this->response(new UserAddressResource($address));
        } else
            return $this->error(__('user::webservice.address.errors.address_not_found'));
    }

    public function delete(Request $request, $id)
    {
        $address = $this->address->findById($id);
        if ($address) {
            $this->address->delete($id);
            return $this->response([]);
        } else
            return $this->error(__('user::webservice.address.errors.address_not_found'));
    }

    public function create(UpdateAddressRequest $request)
    {
        $address = $this->address->create($request);
        $address = $this->address->findById($address['id']);
        return $this->response(new UserAddressResource($address));
    }

    public function makeDefaultAddress(Request $request, $id)
    {
        $address = $this->address->findById($id);
        if ($address) {
            $this->address->makeDefaultAddress($request, $id);
            $address = $this->address->findById($id);
            return $this->response(new UserAddressResource($address));
        } else
            return $this->error(__('user::webservice.address.errors.address_not_found'));
    }
}
