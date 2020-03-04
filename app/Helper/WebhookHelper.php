<?php


namespace App\Helper;


use App\Model\Constance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookHelper extends ApiHelper
{
    private $url;
    private $mainHelper;
    private $categoryHelper;
    private $productHelper;
    private $blogHelper;

    public function __construct()
    {
        parent::__construct();
//        $this->param = $param;

        $this->mainHelper = new MainHelper();
        $this->blogHelper = new BlogHelper();
        $this->categoryHelper = new CategoryHelper();
        $this->productHelper = new ProductHelper();
    }

    private function createWebhook($scope, $param)
    {
        $url = "https://api.bigcommerce.com/" . $param["context"] . "/v2/hooks";
        return $result = $this->client->request("post", $url, [
            "headers" => Constance::getHeader($param),
            "json" => [
                "scope" => $scope,
                "destination" => env("NGROK_URL") . "api/webhooks",
                "is_active" => true
            ]
        ])->getBody()->getContents();
    }

    public function createAllWebhook($param)
    {
        $this->createWebhook("store/product/*", $param);
        $this->createWebhook("store/category/*", $param);
    }

    public function updateDB(Request $request)
    {
        $id = $request->data["id"];
        $context = $request->producer;
        $param = $this->mainHelper->getInfData($context);
        $scopeData = explode("/", $request->scope);
        if ($scopeData[1] == "product") {
            if ($scopeData[2] == "deleted") {
                DB::table("table_products")->delete($id);
            } else {
                $this->productHelper->backUpWithId($param, $id);
            }
        } elseif ($scopeData[1] == "category") {
            if ($scopeData[2] == "deleted") {
                DB::table("table_category")->delete($id);
            } else {
                $this->categoryHelper->insertWithId($param, $id);
            }
        }
    }

}
