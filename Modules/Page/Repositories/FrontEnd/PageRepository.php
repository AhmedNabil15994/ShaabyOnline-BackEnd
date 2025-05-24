<?php

namespace Modules\Page\Repositories\FrontEnd;

use Modules\Page\Entities\Page;
use Hash;
use DB;

class PageRepository
{
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $pages = $this->page->active()->orderBy($order, $sort)->get();
        return $pages;
    }

    public function findBySlug($slug)
    {
        $page = $this->page->anyTranslation('slug', $slug)->first();
        return $page;
    }

    public function findById($id)
    {
        $page = $this->page->find($id);
        return $page;
    }

    public function getAboutUsPage()
    {
        $id = isset(config('setting.other')['about_us']) ? config('setting.other')['about_us'] : 0;
        $page = $this->page->find($id);
        return $page;
    }

    public function checkRouteLocale($model, $slug)
    {
        // if ($model->translate()->where('slug', $slug)->first()->locale != locale()) {
        //     return false;
        // }
        if($array = $model->getTranslations("slug") ){
            $locale = array_search($slug, $array);

            return $locale == locale();
        }

        return true;
    }
}
