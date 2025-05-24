<?php

namespace Modules\Page\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Repositories\FrontEnd\PageRepository as Page;

class PageController extends Controller
{

    function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function page($slug)
    {
        $page = $this->page->findBySlug($slug);

        if(!$page)
            abort(404);

        if ($this->page->checkRouteLocale($page,$slug))
            return view('page::frontend.pages.index',compact('page'));

        return redirect()->route('frontend.pages.index', $page->slug);
    }
}
