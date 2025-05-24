<?php

namespace Modules\Slider\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Slider\Transformers\WebService\SliderResource;
use Modules\Slider\Repositories\WebService\SliderRepository as Slider;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class SliderController extends WebServiceController
{

    function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function slider()
    {
        $slider =  $this->slider->getRandomPerRequest();
        return $this->response(SliderResource::collection($slider));
    }

}
