<?php

namespace App\Http\Controllers;

use App\Exports\KeywordExport;
use App\Helper\ExcelHelper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    private $excelHelper;

    public function __construct()
    {
        $this->excelHelper = new ExcelHelper();
    }

    //
    public function exportKeywordDetail(Request $request)
    {
        return $this->excelHelper->exportKeywordDetail($request->session()->get("param"));
    }

    public function exportKeywordCount(Request $request)
    {
        return $this->excelHelper->exportKeywordCount($request->session()->get("param"));
    }
}
