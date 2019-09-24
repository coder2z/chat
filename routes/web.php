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

Route::get('/', function () {
    return response()->success();
});

//total 42

//吕永杰 2
Route::post('/register' , 'User\LoginController@register');//个人账号注册
Route::post('/uploadPassword' , 'User\LoginController@uploadPassword');//找回密码       （验证码正确了还是会说验证码错误
Route::post('/getCaptcha' , 'User\LoginController@getCaptcha');//获取验证码
Route::post('/login' , 'User\LoginController@login');//账号登陆                         （不能登录
Route::post('/loginOut' , 'User\LoginController@loginOut');//账号注销
Route::group(['middleware' => ['login']],function(){
	Route::post('/suggest' , 'User\LoginController@suggestReturn');//意见反馈
	Route::post('/services/uploadBlackList' , 'Service\ServiceController@uploadBlackList');//上传黑名单申请
	Route::get('/companys/{id}' , 'User\LoginController@getCompanysInfo');//获取指定企业信息
});


//聂鹏郦
//获取短信接口
Route::get('/admin/other/sms','Admin\AdminOtherSettingController@getSmsInfo');
//修改短信接口
Route::post('/admin/other/sms','Admin\AdminOtherSettingController@updateSmsInfo');
//获取ws地址
Route::get('/admin/other/ws','Admin\AdminOtherSettingController@getWsInfo');
//修改ws地址
Route::post('/admin/other/ws','Admin\AdminOtherSettingController@updateWsInfo');


//郑如缘4
Route::group(["prefix"=>"companies"],function(){
    //获取所有当前企业的问题
    Route::get("/{companyid}/questions","Auth\CompanyController@getAllQuestionsInfo");
    //新增问题
    Route::post("/{companyid}/addQuestion","Auth\CompanyController@addQuestion");//能给普通用户添加问题
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
Route::get("/blacklists/{id}","Auth\CompanyController@getAllBalckLists");//没有内容？
//显示指定黑名单详细内容
Route::get("/blacklists/detial/{id}","Auth\CompanyController@showBlackList");
//将指定黑名单人员移除黑名单
Route::delete("/blacklists/{id}","Auth\CompanyController@removeBlackList");//可以重复添加很多次，没有添加凭证
//将指定黑名单人员加入黑名单put
Route::any("/blacklists/{id}","Auth\CompanyController@addBlackList");//？？？any是？？？


//李磊 1

//搜索问题
Route::get('/admin/questions/search','Admin\AdminQuestionOperateController@searchQuestion');
//获取全部问题
Route::get('/admin/questions','Admin\AdminQuestionOperateController@getAllQuestions');
//通过id获取信息
Route::post('/admin/questions/detail','Admin\AdminQuestionOperateController@getQuestionDetailByQuestionId');
//通过审核
Route::post('/admin/questions/access','Admin\AdminQuestionOperateController@accessQuestionByQuestionId');
//取消通过审核
Route::post('/admin/questions/revoke','Admin\AdminQuestionOperateController@revokeQuestionByQuestionId');
//删除问题
Route::delete('/admin/questions','Admin\AdminQuestionOperateController@deleteQuestionByQuestionId');
//更新图片
Route::post('/picture/updatepicture','Picture\PictureUpdateController@updatePicture');
//输出图片
Route::GET('/picture/showpicture/{name}','Picture\PictureUpdateController@showPicture');//不能读取图片

//易康 3
Route::group(['prefix' => 'admin'], function () {
    Route::get('company', 'Admin\AdminCompanyOperateController@getAllCompany');
    Route::post('company', 'Admin\AdminCompanyOperateController@addCompany');
    Route::delete('company', 'Admin\AdminCompanyOperateController@deleteCompanyByCompanyId');
    Route::get('customer', 'Admin\AdminCustomerController@getAllCustomersByCompanyId');//返回客服信息的时候把密码
    Route::get('customer/detail', 'Admin\AdminCustomerController@getCustomerInfoByCustomerId');//不能返回正确客服信息
    Route::post('customer', 'Admin\AdminCustomerController@addCustomer');
    Route::delete('customer', 'Admin\AdminCustomerController@deleteCustomer');//把公司删除了
});

//向良峰 2
Route::get('/admin/person/search','Admin\AdminPersonOperateController@searchPersonalUser');//返回了密码
Route::get('/admin/person','Admin\AdminPersonOperateController@getAllPersonalUser');
Route::post('/admin/person','Admin\AdminPersonOperateController@addPersonalUser');//添加的用户密码为明文，统一手机号重复添加
Route::post('/admin/person/state/update','Admin\AdminPersonOperateController@updatePersonalUserByUserId');
