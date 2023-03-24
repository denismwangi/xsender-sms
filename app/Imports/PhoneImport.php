<?php

namespace App\Imports;

use App\Models\PhoneNumber;
use Maatwebsite\Excel\Concerns\ToModel;

class PhoneImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //dd($row);
        return new PhoneNumber([
            //
              'phone'     => $row[0],
        ]);
    }
}
