<?php

namespace App\Http\Controllers;

use App\Helper\BlogHelper;
use App\Helper\CategoryHelper;
use App\Helper\ProductHelper;
use App\Helper\ResultConfigHelper;
use App\Helper\StoreHelper;
use App\Model\ResultsConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    private $storeHelper;
    private $resultConfigHelper;
    private $productHelper;
    private $categoryHelper;
    private $blogHelper;

    public function __construct()
    {
        $this->storeHelper = new StoreHelper();
        $this->resultConfigHelper = new ResultConfigHelper();
        $this->productHelper = new ProductHelper();
        $this->categoryHelper = new CategoryHelper();
        $this->blogHelper = new BlogHelper();
    }

    //
    public function index(Request $request)
    {
        $param = $request->session()->get("param");
        $store = $this->storeHelper->getStoreInfor($param);
        $resultsPerPage = $this->resultConfigHelper->getResultsPerPage($param);
        $products = $this->productHelper->viewAll($param);
        $categories = $this->categoryHelper->viewAll($param);
        $blogs = $this->blogHelper->viewAll($param);
        return view("config", [
            "store" => $store,
            "resultsPerPage" => $resultsPerPage,
            "param" => $param,
            "products" => $products,
            "blogs" => $blogs,
            "categories" => $categories
        ]);
    }

    public function updateConfig(Request $request)
    {
        $context = $request->context;
        $resultsPerPage = $request->resultsPerPage;
        return $this->resultConfigHelper->editConfigResult($context, $resultsPerPage);
    }
}
