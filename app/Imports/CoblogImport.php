<?php

namespace App\Imports;

use App\CobLog;
use Maatwebsite\Excel\Concerns\ToModel;

class CoblogImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CobLog([
        ]);
    }
}
