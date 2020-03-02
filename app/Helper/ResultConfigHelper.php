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
        if ($resultsPerPage > 0) {
            return DB::table("table_result_config")->where("context", "=", $context)->update([
                "resultsPerPage" => $resultsPerPage
            ]);
        } else {
            throw new \Exception("Result Page isn't valid");
        }
    }

    public function getResultsPerPage($param)
    {
        return ResultsConfig::where("context", "=", $param["context"])
            ->select("resultsPerPage")
            ->get()[0]->resultsPerPage;
    }
}
