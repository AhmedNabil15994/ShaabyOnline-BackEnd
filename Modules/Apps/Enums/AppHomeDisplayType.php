<?php

namespace Modules\Apps\Enums;

class AppHomeDisplayType extends \SplEnum
{
    const __default = self::Carousel;
    const Carousel = "carousel";
    const Grid = "grid";

    public function __construct()
    {
        parent::__construct("carousel");
    }
}
