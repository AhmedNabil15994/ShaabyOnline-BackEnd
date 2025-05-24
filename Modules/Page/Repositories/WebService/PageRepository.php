<?php

namespace Modules\Page\Repositories\WebService;

use Modules\Page\Entities\Page;

class PageRepository
{
    function __construct(Page $page)
    {
        $this->page   = $page;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $pages = $this->page->active()->orderBy($order, $sort)->get();
        return $pages;
    }

    public function findById($id)
    {
        $page = $this->page->active()->where('id',$id)->first();
        return $page;
    }
}
