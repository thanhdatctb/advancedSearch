<?php


namespace App\Helper;


class ResultHelper
{
    private $mainHelper;

    public function __construct()
    {
        $this->mainHelper = new MainHelper();
    }

    public function getResultData($arrayData, $limit)
    {
        return array_chunk($arrayData, $limit);
    }

    
}
