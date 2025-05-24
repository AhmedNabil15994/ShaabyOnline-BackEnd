<?php

namespace Modules\Catalog\Enums;

class ProductFlag extends \SplEnum
{
    const __default = self::Single;
    const Single = "single";
    const Variant = "variant";

    public function __construct()
    {
        parent::__construct("single");
    }
}
