<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('plugs', PlugController::class);//首页轮播图

    $router->resource('activity-cates', ActivityCateController::class);//文章分类

    $router->resource('activities', ActivityController::class);//文章管理

    $router->resource('products', ProductController::class);//产品管理

    $router->resource('settings', SettingController::class);//系统设置

    $router->resource('user-speaks', UserSpeakController::class);//文章评论

    $router->resource('users', UserController::class);//用户管理

    $router->resource('pro-cates', ProCateController::class);//产品类别
});
