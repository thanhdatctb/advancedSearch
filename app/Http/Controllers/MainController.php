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
        $domain = $this->formatDomain($request->url);
        return $this->mainHelper->searchWithoutRequest($domain, $request->keyword);
    }

    private function formatDomain($url)
    {
        $parse = parse_url($url);
        return $parse['host'];
    }

    public function webhook(Request $request)
    {
        $this->mainHelper->backup();
    }
}
