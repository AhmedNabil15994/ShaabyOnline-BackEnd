<?php

namespace Modules\Area\ViewComposers\FrontEnd;

use Modules\Area\Repositories\FrontEnd\StateRepository as State;
use Illuminate\View\View;
use Cache;

class StateComposer
{
    public $states = [];

    public function __construct(State $state)
    {
        $this->states = $state->getAllActiveStates();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('states', $this->states);
    }
}
