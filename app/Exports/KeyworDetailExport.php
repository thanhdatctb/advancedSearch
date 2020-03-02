<?php

namespace App\Exports;

use App\Model\KeywordDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeyworDetailExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $param;
    public function __construct($param)
    {
        $this->param = $param;
    }

    public function collection()
    {
        return KeywordDetail::where("context","=",$this->param["context"])->select()->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'id',
            'create at',
            'update at',
            'search at',
            'keyword',
            'context'
        ];
    }
}
