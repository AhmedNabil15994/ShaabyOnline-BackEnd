<?php

namespace Modules\Area\ViewComposers\Dashboard;

use Modules\Area\Repositories\Dashboard\AreaRepository as Area;
use Illuminate\View\View;
use Cache;

class AreaComposer
{
    public $cityWithStates = [];

    public function __construct(Area $area)
    {
        request()->request->add(['parent_id' => 1]);
        $this->cityWithStates = $area->getCityWithStatesByParent(request());
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('cityWithStates', $this->cityWithStates);
    }
}
