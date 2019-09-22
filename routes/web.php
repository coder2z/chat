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

Route::group(["prefix"=>"companies"],function(){
    //获取所有当前企业的问题
    Route::get("/{companyid}/questions","Auth\CompanyController@getAllQuestionsInfo");
    //新增问题
    Route::post("/{companyid}/addQuestion","Auth\CompanyController@addQuestion");
    //查看客服问答
    Route::get("/{companyid}/showQuestions","Auth\CompanyController@showQuestions");
    //获取首句内容
    Route::get("/{companyid}/getFirstContent","Auth\CompanyController@getFirstContent");
    //修改首句内容put
    Route::post("/{companyid}/updateFirstContent","Auth\CompanyController@updateFirstContent");
    //显示热门问题get
    Route::get("/{companyid}/showHotQuestions","Auth\CompanyController@showHotQuestions");
});
//返回指定客服聊天记录
Route::get("/records/{id}","Auth\CompanyController@getRecordDetail");

//显示所有黑名单
Route::get("/blacklists/{id}","Auth\CompanyController@getAllBalckLists");
//显示指定黑名单详细内容
Route::get("/blacklists/detial/{id}","Auth\CompanyController@showBlackList");
//将指定黑名单人员移除黑名单
Route::delete("/blacklists/{id}","Auth\CompanyController@removeBlackList");
//将指定黑名单人员加入黑名单put
Route::any("/blacklists/{id}","Auth\CompanyController@addBlackList");




