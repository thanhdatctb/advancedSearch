<?php

namespace App\Helper;

use App\Model\Blog;
use App\Model\Constance;
use Illuminate\Support\Facades\DB;

class BlogHelper extends ApiHelper
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
        //print_r($request);
        $result = $this->client->request("get", "api.bigcommerce.com/" . $param["context"] . "/v2/blog/posts.json", [
            "headers" => Constance::getHeader($param)
        ])->getBody()->getContents();
        $blogsData = json_decode($result, true);
        $blogs = array();
        foreach ($blogsData as $blogData) {
            $blog = $this->putAllValueToBlog($blogData);
            array_push($blogs, $blog);
        }
        return ($blogs);
    }

    public function getById($param, $id)
    {
        $uri = "api.bigcommerce.com/" . $param["context"] . "/v2/blog/posts/" . $id . ".json";
        $result = $this->client->request("get", $uri, [
            "headers" => Constance::getHeader($param),
        ])->getBody()->getContents();
        $data = json_decode($result, true);
        return $this->putAllValueToBlog($data);
    }

    private function putAllValueToBlog($blogData)
    {
        $blog = $this->putDBValueToBlog($blogData);

        $blog->setUrl($blogData["url"]);

        $blog->setIsPublished($blogData["is_published"]);
        $blog->setPreviewUrl($blogData["preview_url"]);
        $blog->setSummary($blogData["summary"]);
        $blog->setTag($blogData["tags"]);
        return $blog;
    }

    private function putDBValueToBlog($blogData)
    {
        $blog = new Blog();
        $blog->setAuthor($blogData["author"]);
        $blog->setBody($blogData["body"]);
        $blog->setTitle($blogData["title"]);
        $blog->setId($blogData["id"]);
        return $blog;
    }

    public function backUp($param)
    {
        $blogs = $this->viewAll($param);
        foreach ($blogs as $blog) {
            $this->updateWithId($param, $blog->getId());
        }
    }

    public function insertWithId($param, $id)
    {
        $domain = $this->storeHelper->getStoreInfor($param)["domain"];
        $blog = $this->getById($param, $id);
        DB::table("table_blogs")->insert([
            "id" => $blog->getId(),
            "title" => $blog->getTitle(),
            "body" => strip_tags($blog->getBody()),
            "summary" => strip_tags($blog->getSummary()),
            "author" => $blog->getAuthor(),
            "url" => $blog->getUrl(),
            "context" => $param["context"],
        ]);
    }

    public function updateWithId($param, $id)
    {
        $blog = $this->getById($param, $id);
        DB::table("table_blogs")
            ->where("id", "=", $blog->getId())
            ->insert([
                "title" => $blog->getTitle(),
                "body" => strip_tags($blog->getBody()),
                "summary" => strip_tags($blog->getSummary()),
                "author" => $blog->getAuthor(),
                "url" => $blog->getUrl(),
                "context" => $param["context"],
            ]);
    }

    public function deleteOldData($param)
    {
        DB::table("table_blogs")->where("context", "=", $param["context"])->delete();
    }

    public function search($param, $keyword)
    {
        $result = DB::table("table_blogs")->select("*")
            ->where([
                ["context", "=", $param["context"]],
                ["title", "like", "%" . $keyword . "%"]
            ])
            ->orWhere([
                ["context", "=", $param["context"]],
                ["body", "like", "%" . $keyword . "%"]
            ])
            ->orWhere([
                ["context", "=", $param["context"]],
                ["summary", "like", "%" . $keyword . "%"]
            ])
            ->orWhere([
                ["context", "=", $param["context"]],
                ["author", "like", "%" . $keyword . "%"]
            ])
            ->get();
        $blogs = array();
        foreach ($result as $resultBlog) {
            $blog = $this->getById($param, $resultBlog->id);
            array_push($blog, $blogs);
        }
        return $blogs;
    }

    public function searchWithoutTag($domain, $keyword)
    {
        $context = MainHelper::getInfData("domain", $domain)["context"];
        return DB::table("table_blogs")
            ->where([
                ["table_blogs.context", "=", $context],
                ["table_blogs.title", "like", "%" . $keyword . "%"]
            ])
            ->orWhere([
                ["table_blogs.context", "=", $context],
                ["table_blogs.body", "like", "%" . $keyword . "%"]
            ])
            ->orWhere([
                ["table_blogs.context", "=", $context],
                ["table_blogs.summary", "like", "%" . $keyword . "%"]
            ])
            ->orWhere([
                ["table_blogs.context", "=", $context],
                ["table_blogs.author", "like", "%" . $keyword . "%"]
            ])
            ->select("table_blogs.*")
            ->distinct("table_blog_tags.foreign_id")
            ->get();
    }

    public function searchWithTag($domain, $keyword)
    {
        return DB::table("table_blogs")
            ->join("table_blog_tags", "table_blog_tags.foreign_id", "=", "table_blogs.id")
            ->select("table_blogs.*")
            ->distinct("table_blog_tags.foreign_id")
            ->get();
    }
}
