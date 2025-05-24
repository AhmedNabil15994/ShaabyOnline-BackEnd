<?php

namespace Modules\Variation\ViewComposers\Vendor;

use Modules\Variation\Repositories\Dashboard\OptionRepository as Option;
use Illuminate\View\View;
use Cache;

class OptionComposer
{
    public $options = [];

    public function __construct(Option $option)
    {
        $this->options =  $option->getAllActiveHasValues();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('options' , $this->options);
    }
}
