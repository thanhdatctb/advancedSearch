<?php

namespace App\Http\Controllers;

use App\Helper\TagHelper;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tagHelper;

    //
    public function __construct()
    {
        $this->tagHelper = new TagHelper();
    }

    public function apiAddTag(Request $request)
    {
        $context = $request->context;
        $type = $request->type;
        $tag = $request->tag;
        $foreignId = $request->foreignId;
        $this->tagHelper->insertTag($context, $type, $tag, $foreignId);
    }
}
