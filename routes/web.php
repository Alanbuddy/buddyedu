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

Route::get('/phpinfo', function () {
    phpinfo();
});
Route::middleware(['auth', 'role:admin'])
    ->group(
        function () {
            Route::get('/courses/{course}/enroll', 'CourseController@enrollIn')->name('courses.enroll');//加入课程
            Route::get('/notifications/{notifications}', 'UserController@notificationShow')->name('users.notifications.show');//user's notifications
            Route::get('/test', 'TestController@index')->name('test');
        }
    );

Route::middleware('auth')
    ->group(function () {
        Route::post('/bind/phone', 'UserController@bindPhone')->name('user.phone.bind');
        Route::get('/user/drawings', 'UserController@drawings')->name('user.drawings');
        Route::get('/user/schedules', 'UserController@schedules')->name('user.scheduels');
        Route::get('/notifications', 'UserController@notifications')->name('users.notifications');//user's notifications

//        Route::get('/schedules/search', 'ScheduleController@search')->name('schedule.search');
        Route::get('/schedules/{schedule}/students', 'ScheduleController@enrolls')->name('schedule.student');//某一期课程下的学生
        Route::get('/schedules/{schedule}/{operation}', 'ScheduleController@approve')->name('schedule.approve');
        Route::resource('schedules', 'ScheduleController');

        Route::get('/courses/{course}/merchants', 'CourseController@merchants')->name('course.merchant');//已经获得课程授权的机构
        Route::get('/courses/{course}/comments', 'CourseController@comments')->name('course.comment');
        Route::get('/courses/{course}/schedules/{schedule}/{operation}', 'CourseController@authorizeSchedule')->name('course.schedule.authorize');//课程授权
        Route::resource('courses', 'CourseController');

        Route::get('/teachers/', 'UserController@teacherIndex')->name('teachers.index');
        Route::get('/admins/', 'UserController@adminIndex')->name('admins.index');
        Route::get('/users/{user}/enable', 'UserController@enable')->name('admin.user.enable');
        Route::get('/users/{user}/disable', 'UserController@disable')->name('admin.user.disable');
        Route::resource('users', 'UserController');

        Route::resource('comments', 'CommentController');

        Route::get('/merchants/{merchant}/courses/{course}/{operation}', 'MerchantController@authorizeCourse')->name('merchant.course.authorize');//课程授权
        Route::get('/merchants/{merchant}/courses', 'MerchantController@courses')->name('merchant.courses');//课程授权
        Route::get('/merchants/{merchant}/schedules', 'MerchantController@schedules')->name('merchant.schedules');//开课授权
        Route::get('/merchants/{merchant}/points', 'MerchantController@points')->name('merchant.points');
        Route::get('/merchants/{merchant}/teachers', 'MerchantController@teachers')->name('merchant.teachers');
        Route::get('/merchants/{merchant}/teachers/{teacher}', 'MerchantController@teacher')->name('merchant.teacher.show');
        Route::get('/merchants/{merchant}/users/{user}', 'MerchantController@user')->name('merchant.user.show');
        Route::get('/merchants/{merchant}/orders', 'MerchantController@orders')->name('merchant.orders');
        Route::get('/course-applications', 'MerchantController@courseApplications')->name('merchant.course.application');
        Route::get('/schedule-applications', 'MerchantController@scheduleApplications')->name('merchant.schedule.application');//课程授权
        Route::get('/point-applications', 'MerchantController@pointApplications')->name('merchant.point.application');//课程授权
        Route::get('/merchants/{merchant}/orders/statistics', 'OrderController@merchantTransactions')->name('merchant.order.statistics');
        Route::get('/merchants/{merchant}/orders/statistics/group-by-course', 'OrderController@merchantIncomeGroupByCourse')->name('merchant.order.statistics');
        Route::resource('merchants', 'MerchantController');

        Route::get('/statistics/money/group-by-merchant', 'OrderController@statGroupByMerchant')->name('orders.stat-group-by-merchant');//相关统计信息
        Route::get('/statistics/money/group-by-course', 'OrderController@statGroupByCourse')->name('orders.stat-group-by-course');//相关统计信息
        Route::get('/statistics/money/breakdown', 'OrderController@merchantTransactions')->name('orders.breakdown');
        Route::get('/statistics/users', 'UserController@statistics')->name('users.statistics');//相关统计信息
        Route::resource('order', 'OrderController');

        Route::get('/points/{point}/{operation}', 'PointController@approve')->name('point.approve');//
        Route::resource('points', 'PointController');

        Route::resource('records', 'RecordController');

        Route::resource('files', 'FileController');

    });

Route::get('/form', 'AiController@form')->name('form');
Route::post('/file', 'AiController@store')->name('file');
Route::get('/sms/verify', 'SmsController@sendVerifySms')->name('sms-verify.send');
Route::post('/sms/verify', 'SmsController@validateCode')->name('sms-verify.validate');
Route::get('/sms/send', 'SmsController@send')->name('sms.send');
Route::get('/sms/tpl/add', 'SmsController@addTpl')->name('sms.tpl.add');
Route::get('/password/sms/send', 'Auth\ResetPasswordController@sendResetSms')->name('password.reset.sms');
//用户支付完成后，微信服务器通知商启系统支付情况的回调地址
Route::any('/wechat/payment/notify', 'WechatController@paymentNotify')->name('wechat.payment.notify');

