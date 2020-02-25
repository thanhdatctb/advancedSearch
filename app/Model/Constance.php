<?php


namespace App\Model;

class Constance
{
    public static $request;

    public static function getHeader($param)
    {
        return [
            "X-Auth-Client" => $param["clientId"],
            "X-Auth-Token" => $param["access_token"],
            "Content-Type" => "application/json"
        ];
    }
}
