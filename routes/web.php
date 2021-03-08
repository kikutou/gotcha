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

// Route::name('admin.')->group(function () {

//     Route::get('/', function () {
//         // Route assigned name "admin.users"...
//     })->name('users');

// });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Gotcha
Route::get('/gotcha_list', 'App\Http\Controllers\GotchaController@index')->name('gotcha_list');
Route::get('/gotcha_create', 'App\Http\Controllers\GotchaController@create_index')->name('gotcha_create');
Route::post('/gotcha_create', 'App\Http\Controllers\GotchaController@create_action')->name('gotcha_create');
Route::get('/gotcha_edit', 'App\Http\Controllers\GotchaController@edit_index')->name('gotcha_edit');
Route::post('/gotcha_edit', 'App\Http\Controllers\GotchaController@edit_action')->name('gotcha_edit');

// Prize
Route::get('/prize_list', 'App\Http\Controllers\PrizeController@index')->name('prize_list');
Route::get('/prize_create', 'App\Http\Controllers\PrizeController@create_index')->name('prize_create');
Route::post('/prize_create', 'App\Http\Controllers\PrizeController@create_action')->name('prize_create');
Route::get('/prize_edit', 'App\Http\Controllers\PrizeController@edit_index')->name('prize_edit');
Route::post('/prize_edit', 'App\Http\Controllers\PrizeController@edit_action')->name('prize_edit');

// Picture
Route::get('/picture_list', 'App\Http\Controllers\PictureController@index')->name('picture_list');
Route::get('/picture_create', 'App\Http\Controllers\PictureController@create_index')->name('picture_create');
Route::post('/picture_create', 'App\Http\Controllers\PictureController@create_action')->name('picture_create');
Route::post('/picture_edit', 'App\Http\Controllers\PictureController@edit_index')->name('picture_edit');
// Route::post('/picture_edit', 'App\Http\Controllers\PictureController@edit_action');
// Route::get('/gotcha_register', 'App\Http\Controllers\GotchaController@register')->name('gotcha_register');
// Route::post('/gotcha_register', 'App\Http\Controllers\GotchaController@register')->name('gotcha_register');