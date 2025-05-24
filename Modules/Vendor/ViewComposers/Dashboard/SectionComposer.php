<?php

namespace Modules\Vendor\ViewComposers\Dashboard;

use Modules\Vendor\Repositories\Dashboard\SectionRepository as Section;
use Illuminate\View\View;
use Cache;

class SectionComposer
{
    public $sections = [];

    public function __construct(Section $section)
    {
        $this->sections =  $section->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sections' , $this->sections);
    }
}
