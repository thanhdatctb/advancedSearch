<?php


namespace App\Helper;


use GuzzleHttp\Client;

class ApiHelper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }
}
