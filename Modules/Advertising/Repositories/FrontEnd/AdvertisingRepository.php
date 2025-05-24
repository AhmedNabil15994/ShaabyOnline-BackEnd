<?php

namespace Modules\Advertising\Repositories\FrontEnd;

use Modules\Advertising\Entities\Advertising;

class AdvertisingRepository
{
    protected $advertising;

    function __construct(Advertising $advertising)
    {
        $this->advertising = $advertising;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->advertising->whereNull('deleted_at')->active()->unexpired()->started()
            ->whereHas('advertGroup', function ($query) {
                $query->active();
                $query->whereNull('deleted_at');
            })
            ->inRandomOrder()->take(1)->get();
    }

}
