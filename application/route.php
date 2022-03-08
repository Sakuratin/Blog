<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;

//Route::group( 'index', [
//        'index' => ['Index/Index/index', ['method' => 'get']]
//    ]
//);
Route::get('index', 'Index/Index/index');
Route::get('category/[:category]', 'Index/Index/category');
Route::get('post/[:id]', 'Index/Article/index');
Route::post('post/[:id]', 'Index/Article/index');

Route::post('comment/[:id]', 'Index/Article/comment');
Route::get('delcomment/[:id]', 'Index/Article/delcomment');

Route::get('archives', 'Index/Archives/index');
Route::post('search', 'Index/Search/search');

Route::get("about", 'Index/Index/about');

Route::get('login', 'Index/Login/index');
Route::post('login', 'Index/Login/login');
Route::get('user/logout', 'Index/Login/logout');

Route::get('register', 'Index/Register/index');
Route::post('register', 'Index/Register/register');

Route::get('forget', 'Index/Forget/index');
Route::get('reset/[:token]', 'Index/Forget/reset');
Route::post('reset/[:token]', 'Index/Forget/reset');
Route::post('forget', 'Index/Forget/index');
Route::get("photo", 'Index/Photo/index');
Route::get("photolist/[:pcid]", 'Index/Photo/photolist');



Route::group("admin", [
    "index" => ['Admin/Index/index'],

    "comments" => ['Admin/Comments/index'],
    "comment/delete/[:id]" => ['Admin/Comments/delete'],

    "article/index" => ['Admin/Article/index'],
    "article/create" => ['Admin/Article/create'],
    "article/save" => ['Admin/Article/save'],
    "article/edit/:id" => ['Admin/Article/edit'],
    "article/update/:id" => ['Admin/Article/update'],
    "article/delete/[:id]" => ['Admin/Article/delete'],

    "users" => ['Admin/User/index'],
    "user/show/[:id]" => ['Admin/User/show'],
    "user/update/:id" => ['Admin/User/update'],
    "user/delete/:id" => ['Admin/User/delete'],

    'logout' => ['Admin/Logout/logout'],

    'settings' => ['Admin/Setting/index'],
    'setting/about' => ['Admin/Setting/about'],

    'sensitives' => ['Admin/Sensitive/index'],
    'sensitive/add' => ['Admin/Sensitive/add'],
    'sensitive/delete/[:id]' => ['Admin/Sensitive/delete'],


    'photos' => ['Admin/Photo/index'],
    'photolist/[:id]' => ['Admin/Photo/photolist'],
    'photoupload' => ['Admin/Photo/upload'],
    'photodelete/[:id]' => ['Admin/Photo/delete']
]);

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
