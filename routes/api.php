<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::group(['prefix'=>'/api'],function (){
//
//});
Route::post("/search/", "MainController@apiSearchWithoutRequest")->middleware("addHeader");
Route::post("/webhooks", "WebhookController@main");
Route::post("/keywords", "KeywordController@apiGetAllKeyword")->middleware("addHeader");
Route::post("/updateConfig", "ConfigController@updateConfig")->middleware("addHeader");
Route::post("/addTag", "TagController@apiAddTag");
