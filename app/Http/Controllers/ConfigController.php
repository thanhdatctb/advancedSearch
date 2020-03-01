<?php

namespace App\Http\Controllers;

use App\Helper\ResultConfigHelper;
use App\Helper\StoreHelper;
use App\Model\ResultsConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    private $storeHelper;
    private $resultConfigHelper;
    public function __construct()
    {
        $this->storeHelper = new StoreHelper();
        $this->resultConfigHelper = new ResultConfigHelper();
    }

    //
    public function index(Request $request)
    {
        $param = $request->session()->get("param");
        $store = $this->storeHelper->getStoreInfor($param);
        $resultsPerPage = $this->resultConfigHelper->getResultsPerPage($param);
        return view("config", [
            "store" => $store,
            "resultsPerPage" => $resultsPerPage,
            "param" => $param
        ]);
    }

    public function updateConfig(Request $request)
    {
        $context = $request->context;
        $resultsPerPage = $request->resultsPerPage;
        return $this->resultConfigHelper->editConfigResult($context, $resultsPerPage);
    }
}
