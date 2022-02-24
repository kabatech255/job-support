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
  Route::middleware(['auth:admin', 'org.exists', 'org.match'])->group(function () {
    // User
    Route::post('/user', 'UserController@store')->name('user.store');
    Route::get('/user/{id}', 'UserController@show')->name('user.show');
    // Admin
    Route::post('/admin', 'AdminController@store')->name('admin.store');
    Route::get('/admin/{id}', 'AdminController@show')->name('admin.show');
    // プロフィール
    Route::put('/admin/{id}/profile', 'AdminController@updateProfile')->name('admin.profile');

    Route::middleware(['org.filter'])->group(function () {
      Route::get('/user', 'UserController@index')->name('user.index');
      Route::get('/admin', 'AdminController@index')->name('admin.index');
    });
  });
});
