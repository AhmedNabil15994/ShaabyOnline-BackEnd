<?php

namespace Modules\Vendor\Repositories\FrontEnd;

use Modules\Vendor\Entities\Section;
use Hash;
use DB;

class SectionRepository
{

    function __construct(Section $section)
    {
        $this->section   = $section;
    }

    public function getAllActive()
    {
        $sections = $this->section->whereHas('vendors', function($query){
                        $query
                        ->active()
                        ->whereHas('subbscription', function($query){
                            $query->active()->unexpired()->started();
                            $query;
                        });
                    })->active()->inRandomOrder()->take(3)->get();

        return $sections;
    }

    public function findBySlug($slug)
    {
        $section = $this->section->anyTranslation('slug',$slug)->first();

        return $section;
    }

    public function checkRouteLocale($model,$slug)
    {
        // if ($model->translate()->where('slug', $slug)->first()->locale != locale())
        //     return false;

        if($array = $model->getTranslations("slug") ){
            $locale = array_search($slug, $array);

            return $locale == locale();
        }

        return true;
    }
}
