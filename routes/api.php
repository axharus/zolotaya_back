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

header("Access-Control-Allow-Origin:*");
////header("Access-Control-Expose-Headers:*");
header("Access-Control-Allow-Method:GET,POST");
header("Access-Control-Allow-Headers:content-type, x-xsrf-token");


//Auth
Route::post('/auth/login', 'API\Auth\LoginController@login');
//Route::post('/auth/login', 'API\Auth\LoginController@loginLogin');

Route::post('/auth/registration', 'API\Auth\RegisterController@registration');
//Route::get('/auth/registration/{token}', 'API\Auth\RegisterController@activate')->name('user.activate');

Route::post('/auth/repassword', 'API\Auth\LoginController@repassword');
Route::get('/auth/logout', 'API\Auth\LoginController@logout');

Route::get('/auth/check', 'API\Auth\LoginController@check');

Route::group(['middleware'=> 'auth'], function(){
    Route::post('/stars', 'API\ProductController@stars');

    Route::get('/lk/user', 'API\LkController@getUser');
    Route::get('/lk/orders', 'API\LkController@orders');
    Route::post('/lk/profile', 'API\LkController@updateProfile');
    Route::post('/lk/security', 'API\LkController@updateSecurity');
    Route::post('/lk/dispatch', 'API\LkController@updateDispatch');

    Route::post('/blog/comment/{id}', 'API\BlogController@addComment');
    Route::post('/blog/like/add/{id}', 'API\BlogController@addLike');
    Route::post('/blog/like/remove/{id}', 'API\BlogController@removeLike');
});
//Auth

//DataForAllUser
Route::get('/index', 'API\IndexController@index');
Route::get('/index/more/{offset}', 'API\IndexController@indexGetMore');

Route::get('/head', 'API\IndexController@head');
Route::get('/footer', 'API\IndexController@footer');

Route::get('/catalog', 'API\ProductController@catalog');
Route::get('/product', 'API\ProductController@products');
//Route::post('/product', 'API\ProductController@products'); // Its for liked page
Route::get('/product/comment/{id}', 'API\SingleProductController@getComment');
Route::post('/product/comment', 'API\SingleProductController@addComment');
Route::get('/single_product/{id}', 'API\SingleProductController@get');

Route::get('/card', 'API\Order\CardController@getProducts');
Route::post('/card/order', 'API\Order\CardController@createOrder');
Route::get('/card/region', 'API\Order\CardController@novapochtaRegion');
Route::get('/card/city/{ref}', 'API\Order\CardController@novapochtaCity');
Route::post('/card/simple', 'API\Order\CardController@simple');
Route::get('/card/mini', 'API\Order\CardController@miniBucket');

Route::get('/catalogs/index/{section}', 'API\CatalogsController@get');
Route::get('/catalogs/more/{section}/{offset}', 'API\CatalogsController@more');

Route::get('/blog/tags', 'API\BlogController@tags');
Route::get('/blog/arts', 'API\BlogController@arts');
Route::get('/blog/single/{id}', 'API\BlogController@single');
Route::get('/blog/comment/{id}', 'API\BlogController@getComment');
Route::get('/blog/mini/full', 'API\BlogMiniController@full');
Route::get('/blog/mini/short', 'API\BlogMiniController@short');

Route::get('/contacts', 'API\ContactsController@index');
Route::get('/warehouse', 'API\WhereHouseController@index');
Route::post('/warehouse', 'API\WhereHouseController@mail');

Route::get('/sitemap', 'API\SitemapController@index');
Route::post('/seo/full', 'API\SEOController@full');
Route::post('/seo/tags', 'API\SEOController@tags');


Route::get('/page/{id}', 'API\PagesController@get');
//DataForAllUser

Route::post('/subscribe', 'API\SubscribersController@add');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
