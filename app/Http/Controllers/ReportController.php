<?php

namespace App\Http\Controllers;

use App\Helper\KeywordHelper;
use App\Helper\StoreHelper;
use App\Model\Keyword;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    private $storeHelper;
    private $keywordHelper;

    public function __construct()
    {
        $this->storeHelper = new StoreHelper();
        $this->keywordHelper = new KeywordHelper();
    }

    public function index(Request $request)
    {
        $param = $request->session()->get("param");
        $storeInf = $this->storeHelper->getStoreInfor($param);
        $keywords = $this->keywordHelper->getLimitKeyword(5, $param);
        $top10Keyword = $this->keywordHelper->getLimitKeyword(10, $param);
        $sum = 0;
        foreach ($keywords as $keyword) {
            $sum += $keyword->count;
        }
        $others = new Keyword();
        $others->setAttribute("key_word", "Others");
        $others->setAttribute("count", $this->keywordHelper->getTotalKeyword($param) - $sum);
        $keywords->push($others);
        $top10KeywordToday = array();
        foreach ($top10Keyword as $keyword) {
            $todayKeyword = new Keyword();
            $todayKeyword->setAttribute("key_word", $keyword->key_word);
            $todayKeyword->setAttribute("count", $this->keywordHelper
                ->getTodayKeywordCount($param, $keyword->key_word));
            array_push($top10KeywordToday, $todayKeyword);
        }
        return view("report", [
            "store" => $storeInf,
            "keywords" => $keywords,
            "top10Keyword" => $top10Keyword,
            "top10KeywordToday" => $top10KeywordToday
        ]);
    }
}
