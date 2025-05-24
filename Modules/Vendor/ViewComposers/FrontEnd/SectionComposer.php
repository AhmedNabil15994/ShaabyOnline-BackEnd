<?php

namespace Modules\Vendor\ViewComposers\FrontEnd;

use Modules\Vendor\Repositories\FrontEnd\SectionRepository as Section;
use Illuminate\View\View;
use Cache;

class SectionComposer
{
    public function __construct(Section $section)
    {
        $this->headerSections =  $section->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('headerSections'    , $this->headerSections);
    }
}
