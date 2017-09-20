<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => ['auth:api'],
    'prefix'=>'v1',
], function () {
    Route::post('/cut', 'AiController@cut');
});

Route::post('/file', 'AiController@store');
Route::get('/cut', 'AiController@cut')->name('cut');//调用django接口裁切App发送的原始图片
Route::get('/login', 'LoginController@login')->name('api.login');//调用django接口裁切App发送的原始图片
Route::post('/register', 'AiController@store')->name('api.register');
