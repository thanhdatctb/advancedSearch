<?php

namespace App\Helper;

use App\Model\Category;
use App\Model\Constance;
use Illuminate\Support\Facades\DB;

class CategoryHelper extends ApiHelper
{
    //
    private $storeHelper;

    public function __construct()
    {
        parent::__construct();
        $this->storeHelper = new StoreHelper();
    }

    public function viewAll($param)
    {
//        $abcl = $this->client;
        $result = $this->client->request("get", "api.bigcommerce.com/" . $param["context"] . "/v3/catalog/categories", [
            "headers" => Constance::getHeader($param)
        ])->getBody()->getContents();
        $categoriesData = json_decode($result, true)["data"];
        $categories = array();
        foreach ($categoriesData as $categoryData) {
            $category = $this->putAllValueToCategory($categoryData);
            array_push($categories, $category);

        }
        return ($categories);
    }

    private function putAllValueToCategory($categoryData)
    {
        $category = new \App\Model\Category();
        $category->setName($categoryData["name"]);
        $category->setId($categoryData["id"]);
        $category->setDescription($categoryData["description"]);
        $category->setImageUrl($categoryData["image_url"]);
        $category->setUrl($categoryData["custom_url"]["url"]);
        $category->setParentId($categoryData["parent_id"]);
        $category->setIsVisible($categoryData["is_visible"]);
        return $category;
    }

    public function getById($param, $id)
    {
        $uri = "api.bigcommerce.com/" . $param["context"] . "/v3/catalog/categories/" . $id;
        $result = $this->client->request("get", $uri, [
            "headers" => Constance::getHeader($param),
        ])->getBody()->getContents();
        $categoryData = json_decode($result, true)["data"];
        return $this->putAllValueToCategory($categoryData);
    }

    public function backUp($param)
    {
        $categories = $this->viewAll($param);
        foreach ($categories as $category) {
            $this->insertWithId($param, $category->getId());
        }
    }

    public function insertWithId($param, $id)
    {
        $category = $this->getById($param, $id);
        DB::table("table_category")->insert([
            "id" => $category->getId(),
            "title" => $category->getName(),
            "description" => strip_tags($category->getDescription()),
            "url" => $category->getUrl(),
            "image_url" => $category->getImageUrl(),
            "context" => $param["context"],
        ]);
    }

    public function deleteOldData($param)
    {
        DB::table("table_category")->where("context", "=", $param["context"])->delete();
    }

    public function search($param, $keyword)
    {
        $result = DB::table("table_category")->select()->where([
            ["context", "=", $param["context"]],
            ["title", "like", "%" . $keyword . "%"]
        ])
            ->orWhere([
                ["context", "=", $param["context"]],
                ["description", "like", "%" . $keyword . "%"]
            ])->get();
        $categories = array();
        foreach ($result as $resultCategory) {
            $category = $this->getById($param, $resultCategory->id);
            array_push($categories, $category);
        }
        return $categories;
    }

    public function searchWithoutRequest($domain, $keyword)
    {
        $context = MainHelper::getInfData("domain", $domain)["context"];
        return Category::where([
            ["context", "=", $context],
            ["title", "like", "%" . $keyword . "%"]
        ])
            ->orWhere([
                ["context", "=", $context],
                ["description", "like", "%" . $keyword . "%"]
            ])->get();
    }
}
