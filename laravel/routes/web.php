<?php

use Illuminate\Support\Facades\Route;

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

// Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/login', 'Auth\Auth0IndexController@login')->name('web.login');
// Route::get('/logout', 'Auth\Auth0IndexController@logout')->name('web.logout')->middleware('auth');
// Route::get('/auth0/callback', '\Auth0\Login\Auth0Controller@callback')->name('auth0-callback');
