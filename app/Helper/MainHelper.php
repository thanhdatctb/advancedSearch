<?php

namespace App\Helper;

use App\Jobs\MainJob;
use App\Model\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainHelper extends ApiHelper
{
    private $productHelper;
    private $categoryHelper;
    private $blogHelper;
    private $keywordHelper;
    private $storeHelper;

    public function __construct()
    {
        $this->blogHelper = new BlogHelper();
        $this->categoryHelper = new CategoryHelper();
        $this->productHelper = new ProductHelper();
        $this->keywordHelper = new KeywordHelper();
        $this->storeHelper = new StoreHelper();
    }

    public function backup($param)
    {
        $this->deleteOldData($param);
        $this->productHelper->backUp($param);
        $this->categoryHelper->backUp($param);
        $this->blogHelper->backUp($param);
    }

    public function deleteOldData($param)
    {
        $this->productHelper->deleteOldData($param);
        $this->categoryHelper->deleteOldData($param);
        $this->blogHelper->deleteOldData($param);
    }

    public function search($param, $keyword)
    {
        $this->keywordHelper->logSerchWord($keyword, $param["domain"]);
        $products = $this->productHelper->search($param, $keyword);
        $blogs = $this->blogHelper->search($param, $keyword);
        $categories = $this->categoryHelper->search($param, $keyword);
//        $data = new Data();
//        $data->setCategories($categories);
//        $data->setBlogs($blogs);
//        $data->setProducts($products);
        $data["categories"] = $categories;
        $data["blogs"] = $blogs;
        $data["products"] = $products;
        return $data;
    }

    public function searchWithoutRequest($domain, $keyword)
    {
        $keyword = ($keyword == null ? "" : $keyword);
        $this->keywordHelper->logSerchWord($keyword, $domain);
        $products = $this->productHelper->searchWithoutRequest($domain, $keyword);
        $blogs = $this->blogHelper->searchWithoutRequest($domain, $keyword);
        $categories = $this->categoryHelper->searchWithoutRequest($domain, $keyword);
//        $data = new Data();
//        $data->setCategories($categories);
//        $data->setBlogs($blogs);
//        $data->setProducts($products);
        $data["categories"] = $categories;
        $data["blogs"] = $blogs;
        $data["products"] = $products;
        return response($data);
    }

    public function apiSearchWithoutRequest($store_hash, $keyword)
    {
        $data = $this->searchWithoutRequest($store_hash, $keyword);
        return json_encode($data);
    }

    public function getInfFromContext($context)
    {
        $data = DB::table("table_install_infor")->select()->where("context", "=", $context)->get()->last();
//        $dataDecode = json_decode($data,true);
        $param["clientId"] = $data->clientId;
        $param["clientSecret"] = $data->clientSecret;
        $param["access_token"] = $data->accessToken;
        $param["user_id"] = $data->userId;
        $param["user_email"] = $data->email;
        $param["context"] = $context;
        $domain = $this->storeHelper->getStoreInfor($param)["domain"];
        $param["domain"] = $domain;
        return $param;
    }
}
