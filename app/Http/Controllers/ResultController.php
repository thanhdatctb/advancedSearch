<?php

namespace App\Http\Controllers;

use App\Helper\MainHelper;
use App\Helper\ResultConfigHelper;

class ResultController extends Controller
{
    //
    private $mainHelper;
    private $resultConfigHelper;

    public function __construct()
    {
        $this->mainHelper = new MainHelper();
        $this->resultConfigHelper = new ResultConfigHelper();
    }

    public function getReult($domain, $type, $keyword, $page = 1, $limit = null)
    {
        $param = MainHelper::getInfData("domain", $domain);
        $limitDefault = $this->resultConfigHelper->getResultsPerPage($param);
        $limit = null == $limit ? $limitDefault : $limit;
        $data = $this->mainHelper->searchWithoutRequest($domain, $keyword)[$type];
        $viewData = [
            "type" => $type,
            "data" => null,
            "domain" => $domain,
            "keyword" => $keyword,
            "page" => $page,
            "limit" => $limit,
            "pages" => ceil(sizeof($data) / $limit)
        ];
        if (sizeof($data) == 0) {
            return view("partials/resultHeader", $viewData );
        }
        $outputData = $data->chunk($limit)->toArray()[$page - 1];
        $viewData["data"] = $outputData;
        switch ($type) {
            case "categories":
            {
                return view("CategoriesResult", $viewData);
            }
            case "blogs":
            {
                return view("BlogsResult", $viewData);
            }
            case "products":
            default:
            {
                return view("ProductsResult", $viewData);
            }
        }
    }
}
