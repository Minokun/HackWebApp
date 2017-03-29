<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // 后台登录首页
    Route::any('admin/login','Admin\LoginController@login');
    //后台登录验证码
    Route::get('admin/code','Admin\LoginController@code');

});

Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    //后台首页
    Route::get('index','IndexController@index');
    //信息页面
    Route::get('info','IndexController@info');
    //登出
    Route::get('quit','LoginController@quit');
    //修改密码
    Route::any('pass','IndexController@pass');
    //分类排序
    Route::post('cate/changeOrder','CategoryController@changeOrder');
    //菜单排序
    Route::post('menu/changeOrder','MenuController@changeOrder');
    //权限组开关
    Route::post('power/enable','PowerController@enable');
    //用户开关
    Route::post('user/enable','UserController@enable');
    //点击显示密码
    Route::post('user/showPass','UserController@showPass');

    //注册资源路由
    //文章分类
    Route::resource('category','CategoryController');
    //用户管理
    Route::resource('user','UserController');
    //权限组管理
    Route::resource('power','PowerController');
    //菜单管理
    Route::resource('menu','MenuController');

});
