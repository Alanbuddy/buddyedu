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

Route::group(['middleware' => ['auth', 'auth' => 'role:admin']], function () {
    Route::get('/cut', 'AiController@cut')->name('cut');//调用django接口裁切App发送的原始图片
});
Route::get('/form', 'AiController@form')->name('form');
Route::post('/file', 'AiController@store')->name('file');
Route::get('/sms/send', 'YunpianController@send')->name('sms.send');

//用户支付完成后，微信服务器通知商启系统支付情况的回调地址
Route::any('/wechat/payment/notify', 'WechatController@paymentNotify')->name('wechat.payment.notify');