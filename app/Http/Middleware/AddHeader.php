<?php

namespace App\Http\Middleware;

use Closure;

class AddHeader
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    protected $except = [
        "ExportKeywordDetail",
        "ExportKeywordCount"
    ];

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header("Access-Control-Allow-Origin", "*");
        return $response;
    }
}
