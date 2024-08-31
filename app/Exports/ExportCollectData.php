<?php

namespace App\Exports;

use App\Models\CollectData;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCollectData implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CollectData::all();
    }

    public function map($data)
    {
        return [
            $data->id,
            // $data->
        ];
    }

    public function headings(){
        return  [
            '#',
            'name',
            // 'data'
        ];
    }
}
