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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::auth();

Route::get('/cut', 'AiController@cut')->name('cut');//调用django接口裁切App发送的原始图片
Route::get('/form', 'AiController@form')->name('form');
Route::post('/file', 'AiController@store')->name('file');
