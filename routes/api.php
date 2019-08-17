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

Route::get('users/{user}', function (App\User $user) {
    dd($user);
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('insert', 'CatController@insert');
    Route::post('buycar', 'CatController@buycar');
    Route::post('member_address', 'Member_AddressController@member_address');
    Route::post('address', 'Member_AddressController@address');
    Route::post('show', 'Member_AddressController@show');
    Route::post('greed', 'CatController@greed');
    Route::post('price', 'CatController@price');
    Route::post('car_one', 'Order_detailsController@car_one');
    Route::post('car_two', 'Order_detailsController@car_two');
    Route::post('add', 'Order_detailsController@add');


});



Route::get('index', 'ShowController@index');
Route::get('tree', 'ShowController@tree');
Route::get('cate_gory', 'ShowController@cate_gory');
Route::get('floor', 'ShowController@floor');
Route::post('product', 'ShowController@product');
Route::post('goods', 'ShowController@goods');


Route::group([

    'middleware' => 'api',
    'prefix' => 'pay'

], function ($router) {

    Route::any('index', 'PayController@index');
    Route::get('return', 'PayController@return');
    Route::any('notify', 'PayController@notify');


});
