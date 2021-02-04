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

/**
 * code 兑换 session_key 和 open_id-解密获取用户信息
 */
Route::post('auth/code', 'AuthController@code');

/**
 * 授权路由
 */
Route::middleware('wechat')->group(function() {

    /**
     * 用户登陆授权
     */
    Route::post('auth', 'AuthController@index');

    /**
     * 个人信息
     */
    Route::get('user', 'Community\UserController@user');

    /**
     * 获取手机号
     */
    Route::post('user_phone', 'AuthController@user_phone');

    /**
     * 首页
     */
    Route::get('com_index', 'Community\IndexController@com_index');

    /**
     * 自增浏览次数
     */
    Route::get('line', 'Community\IndexController@line');

    /**
     * 发布转让产品
     */
    Route::post('release_product', 'Community\ProductController@release_product');

    /**
     * 产品列表
     */
    Route::get('product', 'Community\ProductController@product');

    /**
     * 产品详情
     */
    Route::get('productFirst', 'Community\ProductController@productFirst');

    /**
     * 文章列表
     */
    Route::get('actList', 'Community\ActivityController@actList');

    /**
     * 文章详情
     */
    Route::get('actFirst', 'Community\ActivityController@actFirst');

    /**
     * 社区评论
     */
    Route::get('speak', 'Community\ActivityController@speak');

    /**
     * 文章点赞
     */
    Route::get('user_with', 'Community\ActivityController@user_with');

});
