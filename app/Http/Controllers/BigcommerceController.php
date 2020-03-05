<?php

namespace App\Http\Controllers;

use App\Helper\BlogHelper;
use App\Helper\CategoryHelper;
use App\Helper\KeywordHelper;
use App\Helper\MainHelper;
use App\Helper\ProductHelper;
use App\Helper\ResultConfigHelper;
use App\Helper\ScriptHelper;
use App\Helper\StoreHelper;
use App\Helper\WebhookHelper;
use App\Jobs\BackupJob;
use App\Model\Constance;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BigcommerceController extends ApiController
{
    private $storeHelper;
    private $categoryHelper;
    private $productHelper;
    private $blogHelper;
    private $mainHelper;
    private $keywordHelper;
    private $webhookHelper;
    private $scriptHelper;
    private $resultConfigHelper;

    public function __construct()
    {
        $this->storeHelper = new StoreHelper();
        $this->categoryHelper = new CategoryHelper();
        $this->productHelper = new ProductHelper();
        $this->blogHelper = new BlogHelper();
        $this->mainHelper = new MainHelper();
        $this->keywordHelper = new KeywordHelper();
        $this->webhookHelper = new WebhookHelper();
        $this->scriptHelper = new ScriptHelper();
        $this->resultConfigHelper = new ResultConfigHelper();
    }

    private function getAppClientId()
    {
        if (env("APP_ENV") == "local") {
            return env("BC_LOCAL_CLIENT_ID");
        } else {
            return env("BC_APP_CLIENT_ID");
        }
    }

    private function getAppSecret()
    {
        if (env("APP_ENV") == "local") {
            return env("BC_LOCAL_CLIENT_SECRET");
        } else {
            return env("BC_APP_CLIENT_SECRET");
        }
    }

    private function getBaseUrl()
    {
        return env("APP_URL");
    }

    private function getContext(Request $request)
    {
        $signedPayload = $request->input('signed_payload');
        $data = base64_decode(explode(".", $signedPayload)[0]);
        return json_decode($data, true)["context"];
    }

    public function install(Request $request)
    {
        if (!$request->has('code') || !$request->has('scope') || !$request->has('context')) {
            return "Can't install app";
        }
        $client = new Client();
        $result = $client->request("POST", "https://login.bigcommerce.com/oauth2/token", [
            "json" => [
                'client_id' => $this->getAppClientId(),
                'client_secret' => $this->getAppSecret(),
                'redirect_uri' => $this->getBaseUrl() . '/auth/install',
                'grant_type' => 'authorization_code',
                'code' => $request->input('code'),
                'scope' => $request->input('scope'),
                'context' => $request->input('context'),
            ]
        ]);
        $data = json_decode($result->getBody(), true);
        $myParam["clientId"] = $this->getAppClientId();
        $myParam["access_token"] = $data["access_token"];
        $myParam["context"] = $data["context"];
        $domain = $this->storeHelper->getStoreInfor($myParam)["domain"];
        DB::table("table_install_infor")->insert([
            "accessToken" => $data["access_token"],
            "scope" => $data["scope"],
            "clientId" => $this->getAppClientId(),
            "clientSecret" => $this->getAppSecret(),
            "code" => $request->input("code"),
            "userId" => $data["user"]["id"],
            "username" => $data["user"]["username"],
            "email" => $data["user"]["email"],
            "context" => $data["context"],
            "domain" => $domain,
        ]);
        if ($result->getStatusCode() == 200) {
            $context = $data['context'];
            $param = MainHelper::getInfData("context", $context);
            $request->session()->put('param', $param);
            $this->webhookHelper->createAllWebhook($param);
            $this->scriptHelper->createJqueryScript($param);
            $this->scriptHelper->createJquerySuggestScript($param);
            $this->scriptHelper->createSearchScript($param);
            $this->resultConfigHelper->addConfigResult($param, 6);
            $this->backUp($request);
            return redirect("/");
        } else {
            echo($result->getStatusCode());
            return;
        }
    }

    public function load(Request $request)
    {
        $context = $this->getContext($request);
        $param = $this->mainHelper->getInfData("context", $context);
        $request->session()->put('param', $param);
        return redirect(("/"));
    }

    public function backUp(Request $request)
    {
        //print_r($request->session());
        $param = $request->session()->get("param");
        $backupJob = new BackupJob($param);
        $this->dispatch($backupJob);
//        $this->mainController->backup($request);
        return redirect("/");
    }

    public function index(Request $request)
    {
        $param = $request->session()->get("param");
        $storeInf = $this->storeHelper->getStoreInfor($param);
        $categories = $this->categoryHelper->viewAll($param);
        $products = $this->productHelper->viewAll($param);
        $blogs = $this->blogHelper->viewAll($param);
        $keywords = $this->keywordHelper->viewAll($param);
        return view("welcome", [
            "store" => $storeInf,
            "categories" => $categories,
            "products" => $products,
            "blogs" => $blogs,
            "keywords" => $keywords
        ]);
    }

    public function uninstall(Request $request)
    {
        $context = $this->getContext($request);
        DB::table("table_install_infor")->where("context", "=", $context)->delete();
    }
}
