<?php

namespace Modules\Page\ViewComposers\Dashboard;

use Modules\Page\Repositories\Dashboard\PageRepository as Page;
use Illuminate\View\View;
use Cache;

class PageComposer
{
    public $pages = [];

    public function __construct(Page $page)
    {
        $this->pages =  $page->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('pages' , $this->pages);
    }
}
