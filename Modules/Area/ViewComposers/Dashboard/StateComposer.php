<?php

namespace Modules\Area\ViewComposers\Dashboard;

use Modules\Area\Repositories\Dashboard\StateRepository as State;
use Illuminate\View\View;
use Cache;

class StateComposer
{
    public $activeStates = [];

    public function __construct(State $state)
    {
        $this->activeStates =  $state->getAllActive('id', 'desc', null, 1); // get all active states in 'kuwait' country
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['activeStates' => $this->activeStates]);
    }
}
