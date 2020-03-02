<?php

namespace App\Exports;

use App\Model\Keyword;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeywordExport implements FromCollection, WithHeadings
{
    private $param;
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Keyword::where("context","=",$this->param["context"])->select()->get();
    }
    public function headings(): array
    {
        return [
            'id',
            'create at',
            'update at',
            'keyword',
            'count',
            'context'
        ];
    }
}
