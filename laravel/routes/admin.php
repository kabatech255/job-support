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

Route::name('admin.')->group(function () {
  // 認証中の管理ユーザーを返却
  Route::get('/current', 'AdminController@currentAdmin')->name('currentAdmin');

  /**
   * ==========
   * middleware
   * ==========
   * - auth:admin...管理者認証
   * - org.exists...organization_idがnullでない
   * - organization_idとアクセスするリソースのcreatedBy.organization_idが一致する
   */
  Route::middleware(['auth:admin', 'org.exists'])->group(function () {
    // OrganizationPolicyでガードされている
    Route::put('/organization/{id}', 'OrganizationController@update')->name('organization.update')->middleware('activity.job');
    // 都道府県
    Route::get('/prefecture', 'PrefectureController@index')->name('prefecture.index');

    Route::middleware(['org.match'])->group(function () {
      // User
      Route::post('/user', 'UserController@store')->name('user.store')->middleware('activity.job');
      Route::get('/user/{id}', 'UserController@show')->name('user.show');
      Route::put('/user/{id}', 'UserController@update')->name('user.update');
      Route::get('/user/{id}/activity', 'ActivityController@findByCreatedUser')->name('activity.findByCreatedUser');
      // Admin
      Route::post('/admin', 'AdminController@store')->name('admin.store')->middleware('activity.job');
      Route::get('/admin/{id}', 'AdminController@show')->name('admin.show');
      Route::get('/admin/{id}/activity', 'ActivityController@findByCreatedAdmin')->name('activity.findByCreatedAdmin');
      // プロフィール
      Route::put('/admin/{id}/profile', 'AdminController@updateProfile')->name('admin.profile');

      // 会議室
      Route::post('/department', 'DepartmentController@store')->name('department.store')->middleware('activity.job');
      Route::put('/department/{id}', 'DepartmentController@update')->name('department.update');
      Route::delete('/department/{id}', 'DepartmentController@destroy')->name('department.destroy');
      Route::post('/meeting_place', 'MeetingPlaceController@store')->name('meetingPlace.store')->middleware('activity.job');
      Route::put('/meeting_place/{id}', 'MeetingPlaceController@update')->name('meetingPlace.update');
      Route::delete('/meeting_place/{id}', 'MeetingPlaceController@destroy')->name('meetingPlace.destroy');
      Route::post('/progress', 'ProgressController@store')->name('progress.store')->middleware('activity.job');
      Route::put('/progress/{id}', 'ProgressController@update')->name('progress.update');
      Route::delete('/progress/{id}', 'ProgressController@destroy')->name('progress.destroy');

      Route::middleware(['org.filter'])->group(function () {
        Route::get('/user', 'UserController@index')->name('user.index');
        Route::get('/admin', 'AdminController@index')->name('admin.index');
        Route::get('/department', 'DepartmentController@index')->name('department.index');
        Route::get('/meeting_place', 'MeetingPlaceController@index')->name('meetingPlace.index');
        Route::get('/progress', 'ProgressController@index')->name('progress.index');
        Route::get('/activity', 'ActivityController@index')->name('activity.index');
        Route::get('/blog/chart', 'ChartController@blog')->name('chart.blog');
        Route::get('/chat/chart', 'ChartController@chat')->name('chart.chat');
        Route::get('/meeting_record/chart', 'ChartController@meetingRecord')->name('chart.meetingRecord');
      });
    });
  });
});
