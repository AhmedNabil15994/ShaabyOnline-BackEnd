<?php

namespace Modules\Page\ViewComposers\FrontEnd;

use Modules\Page\Repositories\FrontEnd\PageRepository as Page;
use Illuminate\View\View;
use Cache;

class PageComposer
{
    public $aboutUs;
    public $pages = [];

    public function __construct(Page $page)
    {
        $this->pages = $page->getAllActive();
        $this->aboutUs = $page->getAboutUsPage();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['aboutUs' => $this->aboutUs, 'pages' => $this->pages]);
    }
}
