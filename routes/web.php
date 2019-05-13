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

Route::group(['prefix' => 'api'], function () {
    // Route::resource('employees', 'EmployeesController');
});
//Auth::routes();
Route::group(['middleware'=> 'super'], function(){
    Route::get('/superuser/i18n/{lg}', 'Admin\IndexController@lang');
    Route::get('/superuser', 'Admin\IndexController@main');
    Route::get('/superuser/config', 'Admin\IndexController@config');
    Route::post('/superuser/config', 'Admin\IndexController@configSave');

    Route::post('/superuser/ulpoad/image/{width}/{height}', 'UploadController@upload');
    Route::post('/superuser/ulpoad/delete', 'UploadController@delete');

    Route::get('/superuser/contacts', 'Admin\ContactsController@index');
    Route::post('/superuser/contacts', 'Admin\ContactsController@indexSave');

    Route::get('/superuser/wherehouse', 'Admin\WhereHouseController@index');
    Route::post('/superuser/wherehouse', 'Admin\WhereHouseController@indexSave');


    Route::get('/superuser/index', 'Admin\IndexController@index');
    Route::post('/superuser/index', 'Admin\IndexController@indexSave');

    Route::get('/superuser/meta/{type}', 'Admin\MetaController@metaList');
    Route::get('/superuser/meta/edit/{type}/{id}', 'Admin\MetaController@metaEdit');
    Route::get('/superuser/meta/delete/{id}', 'Admin\MetaController@delete');
    Route::post('/superuser/meta/edit/{type}', 'Admin\MetaController@metaSave');

    Route::get('/superuser/product', 'Admin\ProductController@All');
    Route::get('/superuser/product/edit/{id}', 'Admin\ProductController@Edit');
    Route::post('/superuser/product/hotPrice/{id}', 'Admin\ProductController@hotPrice');
    Route::get('/superuser/product/delete/{id}', 'Admin\ProductController@Delete');
    Route::post('/superuser/product/edit', 'Admin\ProductController@Save');


    Route::get('/superuser/orders', 'Admin\OrdersController@All');
    Route::get('/superuser/orders/edit/{id}', 'Admin\OrdersController@Edit');
    Route::get('/superuser/orders/delete/{id}', 'Admin\OrdersController@Delete');
    Route::post('/superuser/orders/edit', 'Admin\OrdersController@Save');

    Route::get('/superuser/user', 'Admin\UserController@Users');
    Route::get('/superuser/admin', 'Admin\UserController@Admin');
    Route::get('/superuser/user/edit/{id}', 'Admin\UserController@Edit');
    Route::get('/superuser/user/delete/{id}', 'Admin\UserController@Delete');
    Route::post('/superuser/user/edit', 'Admin\UserController@Save');

    Route::get('/superuser/blog', 'Admin\BlogController@All');
    Route::get('/superuser/blog/{type}', 'Admin\BlogController@All');
    Route::get('/superuser/blog/{type}/{mod}/edit/{id}', 'Admin\BlogController@Edit');
    Route::get('/superuser/blog/delete/{id}', 'Admin\BlogController@Delete');
    Route::post('/superuser/blog/edit', 'Admin\BlogController@Save');



    Route::get('/superuser/seo', 'Admin\SEOController@All');
    Route::get('/superuser/seo/edit/{id}', 'Admin\SEOController@Edit');
    Route::get('/superuser/seo/delete/{id}', 'Admin\SEOController@Delete');
    Route::post('/superuser/seo/edit', 'Admin\SEOController@Save');

    Route::get('/superuser/comments', 'Admin\CommentsController@All');
    Route::get('/superuser/comments/approve/{id}', 'Admin\CommentsController@Approve');
    Route::get('/superuser/comments/delete/{id}', 'Admin\CommentsController@Delete');


    Route::get('/superuser/pages', 'Admin\PagesController@All');
    Route::get('/superuser/pages/edit/{id}', 'Admin\PagesController@Edit');
    Route::get('/superuser/pages/delete/{id}', 'Admin\PagesController@Delete');
    Route::post('/superuser/pages/edit', 'Admin\PagesController@Save');

    Route::get('/auth/logout', 'Auth\LoginController@logout');
});

Route::post('/login', 'Auth\LoginController@login');
Route::get('/login', 'Auth\LoginController@form');
Route::get('/', function () {
    return redirect('/superuser/index');
});

$router->get( '/_debugbar/assets/stylesheets', '\Barryvdh\Debugbar\Controllers\AssetController@css' );
$router->get( '/_debugbar/assets/javascript', '\Barryvdh\Debugbar\Controllers\AssetController@js' );


// this route is for Angular and it should be placed after all other back end routes
// just keep it at the bottom
//Route::get('/{template}', "TemplateController@index")->where('template', '.*html$');
Route::get('/{any}', "IndexController@index")->where('any', '.*(?!(jpg|png))$');
