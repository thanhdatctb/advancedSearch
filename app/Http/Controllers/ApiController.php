<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }
}
