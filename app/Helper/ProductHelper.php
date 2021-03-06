<?php

namespace App\Helper;

use App\Model\Constance;
use App\Model\Product;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductHelper extends ApiHelper
{
    use ItemHelper;
    //
    private $storeHelper;

    public function __construct()
    {
        parent::__construct();
        $this->storeHelper = new StoreHelper();
    }

    public function viewAll($param)
    {
        $result = $this->client->request("get", "api.bigcommerce.com/" . $param["context"] . "/v3/catalog/products", [
            "headers" => Constance::getHeader($param)
        ])->getBody()->getContents();
        $productsData = json_decode($result, true)["data"];
        $products = array();
        foreach ($productsData as $productData) {
            $product = $this->putAllValueProduct($param, $productData);
            array_push($products, $product);
        }
        return ($products);
    }

    public function viewAllFromDb($param)
    {
        return Product::where("context", '=', $param["context"])->get();

    }

    public function backUp($param)
    {
        $products = $this->viewAll($param);
        foreach ($products as $product) {
            $this->backUpWithId($param, $product->getId());
        }
    }

    public function insertWithId($param, $id)
    {
        $product = $this->getById($param, $id);
        try {
            sizeof($product->getImage());
            $tiny_url = $product->getImage()[0]["tiny_url"];
        } catch (Exception $e) {
            $tiny_url = "";
        }
        DB::table("table_products")->insert([
            "id" => $product->getId(),
            "name" => $product->getName(),
            "Description" => strip_tags($product->getDescription()),
            "url" => $product->getUrl(),
            "image_url" => $tiny_url,
            "context" => $param["context"],
            "price" => $product->getPrice()
        ]);
    }

    public function backUpWithId($param, $id)
    {
//        Product::where("id", "=", $id)->delete();
//        $this->insertWithId($param, $id);
        $product = $this->getById($param, $id);
        DB::table("table_products")
            ->where("id", "=", $id)
            ->update([
                "name" => $product->getName(),
                "Description" => strip_tags($product->getDescription()),
                "url" => $product->getUrl(),
                "image_url" => $product->getImage()[0]["tiny_url"],
                "context" => $param["context"],
                "price" => $product->getPrice()
            ]);
    }


    public function deleteOldData($param)
    {
        DB::table("table_products")->where("context", "=", $param["context"])->delete();
    }

    public function getById($param, $id)
    {
        $url = "api.bigcommerce.com/" . $param["context"] . "/v3/catalog/products/" . $id;
        $result = $this->client->request("get", $url, [
            "headers" => Constance::getHeader($param)
        ])->getBody()->getContents();
        $data = json_decode($result, true);

        return $this->putAllValueProduct($param, $data["data"]);
    }

    public function search($param, $keyword)
    {
        $result = DB::table("table_products")->select()->where([
            ["context", "=", $param["context"]],
            ["name", "like", "%" . $keyword . "%"]
        ])
            ->orWhere([
                ["context", "=", $param["context"]],
                ["Description", "like", "%" . $keyword . "%"]
            ])->get();

        $products = array();
        foreach ($result as $resultProduct) {
            $product = $this->getById($param, $resultProduct->id);
            array_push($products, $product);
        }

        return $products;
    }

    public function searchWithoutTag($domain, $keyword)
    {
        $context = MainHelper::getInfData("domain", $domain)["context"];
        return DB::table("table_products")
            ->select()->where([
                ["table_products.context", "=", $context],
                ["table_products.name", "like", "%" . $keyword . "%"]
            ])
            ->orWhere([
                ["table_products.context", "=", $context],
                ["table_products.Description", "like", "%" . $keyword . "%"]
            ])
            ->get();
    }

    public function searchWithTag($domain, $keyword)
    {
        $context = MainHelper::getInfData("domain", $domain)["context"];
        return DB::table("table_products")
            ->join("table_product_tags", "table_products.id", "=", "table_product_tags.foreign_id")
            ->orWhere([
                ["table_products.context", "=", $context],
                ["table_product_tags.tag", "=", $keyword],
            ])
            ->select("table_products.*")
            ->distinct("table_products.id")->get();
    }

    private function putAllValueProduct($param, $productData)
    {
        $product = $this->putDBValueProduct($productData);
        $product->setUrl($productData["custom_url"]["url"]);
        $product->setPrice($productData["price"]);
        $product->setBrandId($productData["brand_id"]);
        $product->setCategories($productData["categories"]);
        $product->setCondition($productData["condition"]);
        $product->setImage($this->getImage($param, $productData["id"]));
        $product->setSearchKeywords($productData["search_keywords"]);
        $product->setSku($productData["sku"]);
        $product->setType($productData["type"]);
        return $product;
    }

    private function putDBValueProduct($productData)
    {
        $product = new Product();
        $product->setId($productData["id"]);
        $product->setName($productData["name"]);
        $product->setDescription($productData["description"]);
        return $product;
    }

    private function getImage($param, $id)
    {
        $url = "api.bigcommerce.com/" . $param["context"] . "/v2/products/" . $id . "/images.json";
        $result = $this->client->request("get", $url, [
            "headers" => Constance::getHeader($param)
        ])->getBody()->getContents();
        return json_decode($result, true);
    }
}
