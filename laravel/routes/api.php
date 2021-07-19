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

Route::group(['middleware' => 'api'], function () {
  // 認証中の一般ユーザーを返却
  Route::get('/user/current', 'UserController@currentUser')->name('currentUser');
  // 認証手続
  Route::namespace('Auth')->group(function() {
    Route::post('/register', 'RegisterController@register')->name('register');
    Route::post('/login', 'LoginController@login')->name('login');

    Route::middleware('auth')->group(function() {
      Route::post('/logout', 'LoginController@logout')->name('logout');
    });
  });

  // 一般認証が必要なAPI
  Route::middleware('auth')->group(function() {
    // チャットルーム
    Route::get('/author/chat_room', 'ChatRoomController@findByOwner')->name('chatRoom.findByOwner');
    Route::post('/chat_room', 'ChatRoomController@store')->name('chatRoom.store');
    Route::put('/chat_room/{id}', 'ChatRoomController@update')->name('chatRoom.update');
    Route::get('/chat_room/{id}', 'ChatRoomController@show')->name('chatRoom.show');
    Route::delete('/chat_room/{id}', 'ChatRoomController@destroy')->name('chatRoom.destroy');
    // チャットメッセージ
    Route::post('/chat_room/{chat_room_id}/message', 'ChatMessageController@store')->name('chatMessage.store');
    Route::put('/chat_room/{chat_room_id}/message/{id}', 'ChatMessageController@update')->name('chatMessage.update');
    Route::delete('/chat_room/{chat_room_id}/message/{id}', 'ChatMessageController@destroy')->name('chatMessage.destroy');
    // 会議議事録
    Route::get('/author/meeting_record', 'MeetingRecordController@index')->name('meetingRecord.index');
    Route::post('/meeting_record', 'MeetingRecordController@store')->name('meetingRecord.store');
    Route::get('/meeting_record/{id}', 'MeetingRecordController@show')->name('meetingRecord.show');
    Route::put('/meeting_record/{id}', 'MeetingRecordController@update')->name('meetingRecord.update');
    Route::delete('/meeting_record/{id}', 'MeetingRecordController@destroy')->name('meetingRecord.destroy');
  });
});
