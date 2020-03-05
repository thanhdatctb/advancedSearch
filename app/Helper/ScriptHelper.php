<?php


namespace App\Helper;


use App\Enums\LoadMethodEnum;
use App\Enums\LocationEnum;
use App\Enums\VisibilityEnum;
use App\Model\Constance;

class ScriptHelper extends ApiHelper
{
    public function createScriptWithLink($param, $name, $description, $link, $auto_uninstall = true, $load_method = LoadMethodEnum::Default, $location = LocationEnum::head, $visibility = VisibilityEnum::All_pages)
    {
        $url = "https://api.bigcommerce.com/" . $param["context"] . "/v3/content/scripts";
        return $this->client->request("post", $url, [
            "headers" => Constance::getHeader($param),
            "json" => [
                "name" => $name,
                "description" => $description,
                "src" => $link,
                "auto_uninstall" => $auto_uninstall,
                "load_method" => $load_method,
                "location" => $location,
                "visibility" => $visibility,
                "kind" => "src"
            ]
        ])->getBody();
    }

    public function createJqueryScript($param)
    {
        $name = "Jquery";
        $description = "Jquery CDN";
        $link = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js";
        $this->createScriptWithLink($param, $name, $description, $link);
    }

    public function createJquerySuggestScript($param)
    {
        $name = "JquerySuggest";
        $description = "Jquery Suggest";
        $link = "https://rawgithub.com/polarblau/suggest/master/src/jquery.suggest.js";
        $this->createScriptWithLink($param, $name, $description, $link);
    }
    public function createSearchScript($param)
    {
        $name = "Advanced Search";
        $description = "Advanced Search Script";
        $link = env("NGROK_URL") . "search.js";
        $this->createScriptWithLink($param, $name, $description, $link, true, LoadMethodEnum::Default, LocationEnum::footer, VisibilityEnum::All_pages);
    }
}
