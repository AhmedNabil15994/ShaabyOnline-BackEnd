<?php

namespace Modules\Variation\ViewComposers\Dashboard;

use Modules\Variation\Repositories\Dashboard\OptionRepository as Option;
use Illuminate\View\View;
use Cache;

class FindOptionValuesComposer
{
    public $optionValues = [];

    public function __construct(Option $values)
    {
        $this->optionValues =  $values;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('optionValues' , $this->optionValues);
    }
}
