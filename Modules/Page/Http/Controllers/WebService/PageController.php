<?php

namespace Modules\Page\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Page\Transformers\WebService\PageResource;
use Modules\Page\Repositories\WebService\PageRepository as Page;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class PageController extends WebServiceController
{

    function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function pages()
    {
        $pages =  $this->page->getAllActive();

        return $this->response(PageResource::collection($pages));
    }

    public function page($id)
    {
        $page = $this->page->findById($id);

        if(!$page)
          return $this->response([]);

        return $this->response(new PageResource($page));
    }
}
