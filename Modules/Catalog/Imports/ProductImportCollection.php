<?php


namespace Modules\Catalog\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToArray;

class ProductImportCollection implements ToArray, WithHeadingRow
{

    public function array(array $array){
        //
    }
}
