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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', '\App\Http\Controllers\CalendarController@show');

//祝日設定
Route::get('/holiday_setting', '\App\Http\Controllers\Calendar\HolidaySettingController@form')
->name("holiday_setting");
Route::post('/holiday_setting', '\App\Http\Controllers\Calendar\HolidaySettingController@update')
->name("update_holiday_setting");
