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

Route::auth();
//Route::get('/', function () { return redirect('/schedules'); });
Route::get('/home', 'HomeController@home')->name('home');
Route::get('/schedules/enroll/{schedule}', 'HomeController@index')->name('landing');

Route::get('/phpinfo', function () {
    phpinfo();
});
Route::middleware(['auth', 'role:admin'])
    ->group(
        function () {
            Route::get('/notifications/{notifications}', 'UserController@notificationShow')->name('users.notifications.show');//user's notifications
            Route::get('/test', 'TestController@index')->name('test');
        }
    );

Route::middleware('auth')
    ->group(function () {
        Route::get('/bind/phone', 'UserController@showBindPhoneForm')->name('user.phone.bind.form');
        Route::post('/bind/phone', 'UserController@bindPhone')->name('user.phone.bind');
        Route::get('/user/drawings', 'UserController@drawings')->name('user.drawings');
        Route::get('/user/drawings/{drawing}', 'UserController@drawing')->name('user.drawings.show');
        Route::get('/user/schedules', 'UserController@schedules')->name('user.schedules');
        Route::get('/profile', 'UserController@profile')->name('profile');
        Route::post('/profile', 'UserController@updateProfile')->name('profile.update');
        Route::get('/notifications', 'UserController@notifications')->name('users.notifications');//user's notifications

//        Route::get('/schedules/search', 'ScheduleController@search')->name('schedule.search');
        Route::get('/schedules/{schedule}/enroll/success', 'ScheduleController@enrolled')->name('schedules.enrolled');//成功加入课程
        Route::post('/schedules/{schedule}/prepay', 'OrderController@prepay')->name('prepay');
        Route::get('/schedules/{schedule}/students', 'ScheduleController@enrolls')->name('schedule.student');//某一期课程下的学生
        Route::get('/schedule/{schedule}/comments', 'ScheduleController@comments')->name('schedule.comments');
        Route::get('/schedules/{schedule}/{operation}', 'ScheduleController@approve')->name('schedule.approve');
        Route::resource('schedules', 'ScheduleController');

        Route::get('/courses/{course}/merchants', 'CourseController@merchants')->name('course.merchant');//已经获得课程授权的机构
        Route::any('/courses/{course}/apply', 'CourseController@apply')->name('course.apply');//apply for course authorization
        Route::get('/courses/{course}/schedules/{schedule}/{operation}', 'CourseController@authorizeSchedule')->name('course.schedule.authorize');//课程授权
        Route::resource('courses', 'CourseController');

        Route::get('/teachers/', 'UserController@teacherIndex')->name('teachers.index');
        Route::get('/admins/', 'UserController@adminIndex')->name('admins.index');
        Route::get('/users/{user}/enable', 'UserController@enable')->name('admin.user.enable');
        Route::get('/users/{user}/disable', 'UserController@disable')->name('admin.user.disable');
        Route::get('/users/{user}/schedules/{schedule}/attendances', 'UserController@attendances')->name('user.attendances');
        Route::resource('users', 'UserController');

        Route::resource('comments', 'CommentController');

        Route::get('/merchants/{merchant}/courses/{course}/{operation}', 'MerchantController@authorizeCourse')->name('merchant.course.authorize');//课程授权
        Route::get('/merchants/{merchant}/points/{point}/{operation}', 'MerchantController@authorizePoint')->name('merchant.point.authorize');
        Route::get('/merchants/{merchant}/courses', 'MerchantController@courses')->name('merchant.courses');
        Route::get('/merchants/{merchant}/schedules', 'MerchantController@schedules')->name('merchant.schedules');
        Route::get('/merchants/{merchant}/points', 'MerchantController@points')->name('merchant.points');
        Route::get('/merchants/{merchant}/teachers', 'MerchantController@teachers')->name('merchant.teachers');
        Route::get('/merchants/{merchant}/teachers/{teacher}', 'MerchantController@teacher')->name('merchant.teacher.show');
        Route::get('/merchants/{merchant}/users/{user}', 'MerchantController@user')->name('merchant.user.show');
        Route::get('/merchants/{merchant}/orders', 'MerchantController@orders')->name('merchant.orders');
        Route::get('/merchants/{merchant}/files', 'MerchantController@files')->name('merchant.files');
        Route::get('/applications/course', 'MerchantController@courseApplications')->name('merchant.course.application');
        Route::get('/applications/schedule', 'MerchantController@scheduleApplications')->name('merchant.schedule.application');
        Route::get('/applications/schedules/{schedule}', 'MerchantController@scheduleShow')->name('application.schedule.show');
        Route::get('/applications/point', 'MerchantController@pointApplications')->name('merchant.point.application');
        Route::get('/applications/withdraw', 'MerchantController@withdrawApplications')->name('merchant.withdraw.application');
        Route::get('/withdraw/breakdown', 'OrderController@withdrawBreakdown')->name('withdraw.breakdown');
        Route::get('/merchants/{merchant}/orders/statistics', 'OrderController@merchantTransactions')->name('merchant.order.statistics');
        Route::get('/merchants/{merchant}/orders/statistics/group-by-course', 'OrderController@merchantIncomeGroupByCourse')->name('merchant.order.statistics');
        Route::resource('merchants', 'MerchantController');

        Route::get('/statistics/money/group-by-merchant', 'OrderController@statGroupByMerchant')->name('orders.stat-group-by-merchant');//相关统计信息
        Route::get('/statistics/money/group-by-course', 'OrderController@statGroupByCourse')->name('orders.stat-group-by-course');//金额统计 各课程收入
        Route::get('/statistics/money/breakdown', 'OrderController@merchantTransactions')->name('orders.breakdown');
        Route::get('/statistics/money/breakdown/export', 'OrderController@exportCsv')->name('orders.breakdown.export');
        Route::get('/statistics/users', 'UserController@statistics')->name('users.statistics');//相关统计信息
        Route::resource('order', 'OrderController');

        Route::get('/point/nearby', 'PointController@nearby')->name('point.nearby');
        Route::resource('points', 'PointController');

        Route::resource('records', 'RecordController');

        Route::get('/files/upload/init', 'FileController@initChunkUpload')->name('file.upload.init');
        Route::post('/files/merge', 'FileController@mergeFile')->name('files.merge');
        Route::get('/files/{file}/download', 'FileController@download')->name('file.download');
        Route::resource('files', 'FileController');
        Route::get('/applications/{application}/reject', 'ApplicationController@reject')->name('application.reject');
        Route::get('/applications/{application}/approve', 'ApplicationController@approve')->name('application.approve');
        Route::resource('applications', 'ApplicationController');
    });

Route::get('/qr', 'HomeController@qr')->name('qr');
Route::get('/form', 'AiController@form')->name('form');
Route::post('/file', 'AiController@store')->name('file');
Route::get('/validate-phone', 'SmsController@isOccupied')->name('validate.phone');
Route::get('/sms/verify', 'SmsController@sendVerifySms')->name('sms.verify');
Route::post('/sms/verify', 'SmsController@validateCode')->name('sms-verify.validate');
Route::get('/sms/send-code', 'SmsController@sendVerificationCode')->name('sms.send');
Route::get('/sms/tpl/add', 'SmsController@addTpl')->name('sms.tpl.add');
Route::get('/password/sms/send', 'Auth\ResetPasswordController@sendResetSms')->name('password.reset.sms');
//用户支付完成后，微信服务器通知商启系统支付情况的回调地址
Route::any('/wechat/payment/notify', 'WechatController@paymentNotify')->name('wechat.payment.notify');
Route::get('/wechat/message/get-industry', 'WechatController@getIndustry')->name('wechat.getIndustry');
Route::get('/wechat/message/get-template', 'WechatController@getTemplate')->name('wechat.getTemplate');
Route::get('/wechat/message/template-id', 'WechatController@getTemplateID')->name('wechat.getTemplateID');
Route::get('/wechat/access-token', 'WechatController@accessToken')->name('wechat.accessToken');
Route::get('/wechat/login', 'WechatController@login')->name('wechat.login');
Route::get('/wechat/openid', 'WechatController@openid')->name('wechat.openid');
Route::get('/wechat/send', 'WechatController@send')->name('wechat.send');
Route::get('/wechat/users/{user}/userinfo', 'WechatController@userInfo')->name('wechat.userinfo');


