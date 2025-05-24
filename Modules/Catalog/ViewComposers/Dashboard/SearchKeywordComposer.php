<?php

namespace Modules\Catalog\ViewComposers\Dashboard;

use Modules\Catalog\Repositories\Dashboard\SearchKeywordsRepository as SearchKeyword;
use Illuminate\View\View;

class SearchKeywordComposer
{
    public $keywords;

    public function __construct(SearchKeyword $keywords)
    {
        $this->keywords = $keywords->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['searchKeywords' => $this->keywords]);
    }
}
