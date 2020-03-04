<?php


namespace App\Helper;


trait ItemHelper
{
    public function searchWithoutTag($domain, $keyword)
    {
    }

    public function searchWithTag($domain, $keyword)
    {
    }

    public function searchWithoutRequest($domain, $keyword)
    {
        $resultWithoutTag = $this->searchWithoutTag($domain, $keyword);
        $resutlTag = $this->searchWithTag($domain, $keyword);
        return $resultWithoutTag->merge($resutlTag)->unique();
    }
}
