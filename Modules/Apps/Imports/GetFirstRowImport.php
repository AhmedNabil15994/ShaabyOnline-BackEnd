<?php


namespace Modules\Apps\Imports;

use Maatwebsite\Excel\Concerns\ToModel;

class GetFirstRowImport implements ToModel
{
    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|void|null
     */
    public function model(array $row)
    {

    }
}