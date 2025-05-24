<?php

namespace Modules\User\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Catalog\Transformers\WebService\ProductResource;

use Modules\User\Http\Requests\WebService\StoreFavouriteRequest;
use Modules\User\Repositories\WebService\UserRepository as User;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class UserFavouritesController extends WebServiceController
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function list()
    {
        $favouritesProducts = auth()->user()->favourites;
        return $this->response(ProductResource::collection($favouritesProducts));
    }

    public function store(StoreFavouriteRequest $request)
    {
        $favourite = $this->user->findFavourite(auth()->user()->id, $request->product_id);

        if (!$favourite)
            $check = $this->user->createFavourite(auth()->user()->id, $request->product_id);
        else
            return $this->error(__('user::frontend.favourites.index.alert.exist'));

        if ($check) {
            $data = [
                "favouritesCount" => auth()->user()->favourites()->count(),
            ];
            return $this->response($data, __('user::frontend.favourites.index.alert.success'));
        }

        return $this->error(__('user::frontend.favourites.index.alert.error'));
    }

    public function delete($id)
    {
        $favourite = $this->user->findFavourite(auth()->user()->id, $id);
        if (!$favourite)
            return $this->error(__('user::frontend.favourites.index.alert.not_found'));

        $check = $favourite->delete();

        if ($check)
            return $this->response([], __('user::frontend.favourites.index.alert.delete'));

        return $this->error(__('user::frontend.favourites.index.alert.error'));
    }

}
