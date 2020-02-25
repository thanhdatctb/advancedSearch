<?php


namespace App\Helper;


use App\Exports\KeyworDetailExport;
use App\Exports\KeywordExport;
use App\Model\Product;
use Maatwebsite\Excel\Facades\Excel;


class ExcelHelper
{
    public function exportKeywordCount($param)
    {
        $fileName = $param["domain"] . "_Keyword_count.xlsx";
        return Excel::download(new KeywordExport($param), $fileName);
    }

    public function exportKeywordDetail($param)
    {
        $fileName = $param["domain"] . "_Keyword_detail.xlsx";
        return Excel::download(new KeyworDetailExport($param), $fileName);
    }
}
