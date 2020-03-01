<?php


namespace App\Helper;


use App\Model\ResultsConfig;
use Illuminate\Support\Facades\DB;

class ResultConfigHelper
{
    public function addConfigResult($param, $resultsPerPage)
    {
        DB::table("table_result_config")->insert([
            "context" => $param["context"],
            "resultsPerPage" => $resultsPerPage
        ]);
    }

    public function editConfigResult($context, $resultsPerPage)
    {
        return DB::table("table_result_config")->where("context", "=", $context)->update([
            "resultsPerPage" => $resultsPerPage
        ]);
    }

    public function getResultsPerPage($param)
    {
        return ResultsConfig::where("context", "=", $param["context"])
            ->select("resultsPerPage")
            ->get()[0]->resultsPerPage;
    }
}
