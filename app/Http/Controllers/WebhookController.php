<?php

namespace App\Http\Controllers;

use App\Helper\WebhookHelper;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    private $webhookHelper;

    public function __construct()
    {
        $this->webhookHelper = new WebhookHelper();
    }

    public function test(Request $request)
    {
        $webhookHelper = new WebhookHelper($request->session()->get("param"));
        $webhookHelper->createProductWebhook();
    }

    public function main(Request $request)
    {
        $this->webhookHelper->updateDB($request);
    }
}
