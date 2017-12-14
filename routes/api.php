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

Route::middleware(['auth:api'])
//Route::middleware(['va'])
    ->prefix('v1')
    ->group(
        function () {
            Route::get('/get', 'AiController@cut');
            Route::post('/cut', 'AiController@cut')->name('cut');
            Route::post('/bone', 'AiController@bone')->name('bone');
            Route::resource('files', 'FileController');
            Route::get('/schedules', 'ScheduleController@latest')->name('api.merchants.schedules.latest4');
            Route::get('/schedules/students', 'ScheduleController@students')->name('schedule.student');//某一期课程下的学生

            Route::get('/schedules/attendances', 'ScheduleController@attendances')->name('schedule.attendances');
        });

Route::post('/file', 'AiController@store');
//Route::get('/cut', 'AiController@cut')->name('cut');//调用django接口裁切App发送的原始图片


Route::get('/test', 'TestController@apiIndex');
Route::post('/login', 'Auth\LoginController@login')->name('api.login');
Route::get('/login/sms', 'Auth\LoginController@sendVerifySmsForLogin')->name('api.login.sms.send');
Route::post('/login/sms', 'Auth\LoginController@loginBySms')->name('api.login.sms');
Route::post('/register', 'Auth\RegisterController@register')->name('api.register');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('api.password.reset');

