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
    'prefix' => 'v1',
], function () {
    Route::get('/get', 'AiController@cut');
    Route::post('/cut', 'AiController@cut')->name('cut');
    Route::post('/bone', 'AiController@bone')->name('bone');
});

Route::post('/file', 'AiController@store');
//Route::get('/cut', 'AiController@cut')->name('cut');//调用django接口裁切App发送的原始图片

Route::resource('files','FileController');

Route::post('/login', 'Auth\LoginController@login')->name('api.login');
Route::post('/register', 'Auth\RegisterController@register')->name('api.register');
