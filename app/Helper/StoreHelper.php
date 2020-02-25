<?php

namespace App\Helper;

use App\Model\Constance;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class StoreHelper extends ApiHelper
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getStoreInfor($param)
    {
        $result = $this->client->request("get", "api.bigcommerce.com/".$param["context"]."/v2/store.json", [
            "headers"=>Constance::getHeader($param)
        ])->getBody()->getContents();
        $data = json_decode($result, true);
        $store["logo"] = $data["logo"]["url"];
        $store["name"] = $data["name"];
        $store["domain"] = $data["domain"];
        return $store;
    }
}
