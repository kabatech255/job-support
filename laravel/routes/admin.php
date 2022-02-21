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

  // 管理者認証が必要なAPI
  Route::middleware(['auth:admin', 'org.exists'])->group(function () {
    // 組織情報の登録後にアクセス可能なエンドポイント
    // User
    Route::post('/user', 'UserController@store')->name('user.store');
    // Admin
    Route::post('/admin', 'AdminController@store')->name('admin.store');

    Route::middleware(['auth:admin', 'org.filter'])->group(function () {
      Route::get('/user', 'UserController@index')->name('user.index');
      Route::get('/admin', 'AdminController@index')->name('admin.index');
    });
  });
});
