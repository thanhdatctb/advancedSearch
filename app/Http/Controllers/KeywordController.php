<?php

namespace App\Http\Controllers;

use App\Helper\KeywordHelper;
use App\Helper\MainHelper;
use App\Model\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    //
    private $keywordHelper;

    public function __construct()
    {
        $this->keywordHelper = new KeywordHelper();
    }

    public function apiGetAllKeyword(Request $request)
    {
        $domain = MainHelper::formatDomain($request->url);
        $param = MainHelper::getInfData("domain", $domain);
        return $this->keywordHelper->viewAll($param);
    }
}
