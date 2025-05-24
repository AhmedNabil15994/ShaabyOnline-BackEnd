<?php

namespace Modules\Advertising\Repositories\WebService;

use Modules\Advertising\Entities\Advertising;
use Modules\Advertising\Entities\AdvertisingGroup;

class AdvertisingRepository
{
    protected $advertising;
    protected $adGroup;

    function __construct(Advertising $advertising, AdvertisingGroup $adGroup)
    {
        $this->advertising = $advertising;
        $this->adGroup = $adGroup;
    }

    public function getRandomPerRequest()
    {
        return $this->advertising->whereNull('deleted_at')->active()->unexpired()->started()
            ->whereHas('advertGroup', function ($query) {
                $query->active();
                $query->whereNull('deleted_at');
            })
            ->inRandomOrder()->get();
    }

    public function getAdvertGroups($position = 'home')
    {
        $groups = $this->adGroup->whereNull('deleted_at')->active()->with(['adverts' => function ($query) {
            $query->whereNull('deleted_at')->active()->unexpired()->started()->orderBy('sort', 'asc');
        }]);
        $groups = $groups->where('position', $position);
        return $groups->orderBy('sort', 'asc')->get();
    }
}
