<?php

namespace App\Http\Controllers;

use App\Helper\MainHelper;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    private $mainHelper;

    public function __construct()
    {
        $this->mainHelper = new MainHelper();
    }

    public function apiSearchWithoutRequest(Request $request)
    {
        $domain = MainHelper::formatDomain($request->url);
        return $this->mainHelper->searchWithoutRequest($domain, $request->keyword);
    }

    public function webhook(Request $request)
    {
        $this->mainHelper->backup();
    }
}
