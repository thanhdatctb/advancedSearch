<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "BigcommerceController@index");
Route::group(['prefix' => '/auth'], function () {
    Route::get('/install', "BigcommerceController@install");
    Route::get('uninstall', "BigcommerceController@uninstall");
    Route::get('load', "BigcommerceController@load");
});

Route::get("/backup", "BigcommerceController@backUp");
//Route::get("/webhooks","MainController@testWebhook");
Route::get("/search", "MainController@search");
Route::get("/report", "ReportController@index");

Route::get("/ExportKeywordDetail", "ExcelController@exportKeywordDetail");
Route::get("/ExportKeywordCount", "ExcelController@exportKeywordCount");
