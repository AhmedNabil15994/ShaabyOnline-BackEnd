<?php

namespace Modules\User\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Traits\AuthenticationTrait;
use Modules\User\Http\Requests\FrontEnd\UpdateProfileRequest;
use Modules\User\Http\Requests\FrontEnd\UpdateAddressRequest;
use Modules\User\Repositories\FrontEnd\UserRepository as User;
use Modules\User\Repositories\FrontEnd\AddressRepository as Address;

class UserController extends Controller
{
    use AuthenticationTrait;

    protected $user;
    protected $address;

    function __construct(User $user, Address $address)
    {
        $this->user = $user;
        $this->address = $address;
    }

    public function index()
    {
        return view('user::frontend.profile.index');
    }

    public function favourites()
    {
        $favourites = auth()->user()->favourites;
        return view('user::frontend.profile.favourites', compact('favourites'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        // check if user change mobile
        if (!is_null($request->mobile) && $request->mobile != auth()->user()->mobile) {
            $request->request->add(['mobile_verified_at' => null, 'firebase_id' => null]);
        }

        $update = $this->user->update($request, auth()->id());
        if ($update)
            return redirect()->back()->with(['alert' => 'success', 'status' => __('user::frontend.profile.index.alert.success')]);

        return redirect()->back()->with(['alert' => 'danger', 'status' => __('user::frontend.profile.index.alert.error')]);
    }

    public function addresses()
    {
        $addresses = $this->address->getAllByUsrId();
        return view('user::frontend.profile.addresses.index', compact('addresses'));
    }

    public function createAddress()
    {
        return view('user::frontend.profile.addresses.create');
    }

    public function storeAddress(UpdateAddressRequest $request)
    {
        $update = $this->address->create($request);

        if ($update) {
            if ($request->state) {
                // Save user state for later operations
                set_cookie_value(config('core.config.constants.ORDER_STATE_ID'), $request->state);
                set_cookie_value(config('core.config.constants.ORDER_STATE_NAME'), $request->order_state_name);
            }
            return redirect()->back()->with(['alert' => 'success', 'status' => __('user::frontend.addresses.index.alert.success_')]);
        }

        return redirect()->back()->with(['alert' => 'danger', 'status' => __('user::frontend.addresses.index.alert.error')]);
    }

    public function editAddress($id)
    {
        $address = $this->address->findById($id);
        return view('user::frontend.profile.addresses.address', compact('address'));
    }

    public function updateAddress(UpdateAddressRequest $request, $id)
    {
        $update = $this->address->update($request, $id);

        if ($update) {
            if ($request->state) {
                // Save user state for later operations
                set_cookie_value(config('core.config.constants.ORDER_STATE_ID'), $request->state);
                set_cookie_value(config('core.config.constants.ORDER_STATE_NAME'), $request->order_state_name);
            }
            return redirect()->back()->with(['alert' => 'success', 'status' => __('user::frontend.addresses.index.alert.success')]);
        }

        return redirect()->back()->with(['alert' => 'danger', 'status' => __('user::frontend.addresses.index.alert.error')]);
    }

    public function deleteAddress($id)
    {
        $update = $this->address->delete($id);

        if ($update)
            return redirect()->back()->with(['alert' => 'success', 'status' => __('user::frontend.addresses.index.alert.delete')]);;

        return redirect()->back()->with(['alert' => 'danger', 'status' => __('user::frontend.addresses.index.alert.error')]);
    }

    public function deleteFavourite($prdId)
    {
        $favourite = $this->user->findFavourite(auth()->user()->id, $prdId);
        $check = $favourite->delete();

        if ($check)
            return redirect()->back()->with(['alert' => 'success', 'status' => __('user::frontend.favourites.index.alert.delete')]);;

        return redirect()->back()->with(['alert' => 'danger', 'status' => __('user::frontend.favourites.index.alert.error')]);
    }

    public function storeFavourite($prdId)
    {
        $favourite = $this->user->findFavourite(auth()->user()->id, $prdId);

        if (!$favourite)
            $check = $this->user->createFavourite(auth()->user()->id, $prdId);
        else
            return response()->json(["errors" => __('user::frontend.favourites.index.alert.exist')], 422);

        if ($check) {
            $data = [
                "favouritesCount" => auth()->user()->favourites()->count(),
            ];
            return response()->json(["message" => __('user::frontend.favourites.index.alert.success'), "data" => $data], 200);
        }

        return response()->json(["errors" => __('user::frontend.favourites.index.alert.error')], 422);
    }

}
