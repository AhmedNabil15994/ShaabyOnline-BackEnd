<?php

namespace Modules\Variation\Repositories\FrontEnd;

use Modules\Variation\Entities\OptionValue;
use Modules\Variation\Entities\Option;
use Hash;
use DB;

class OptionRepository
{

    function __construct(Option $option,OptionValue $value)
    {
        $this->value    = $value;
        $this->option   = $option;
    }

}
