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

// Route::post('/add_user_ticket', 'App\Http\Controllers\Api\GotchaController@add_user_ticket')->name('post_add_user_ticket');
// Route::post('/disp_gotchas', 'App\Http\Controllers\Api\GotchaController@disp_gotchas')->name('post_disp_gotchas');
// Route::post('/gotcha_detail', 'App\Http\Controllers\Api\GotchaController@gotcha_detail')->name('post_gotcha_detail');
// Route::post('/gotcha_result', 'App\Http\Controllers\Api\GotchaController@gotcha_result')->name('post_gotcha_result');

Route::post('/add_user_ticket', 'App\Http\Controllers\Api\GotchaController@add_user_ticket')->name('post_add_user_ticket')->middleware("check_user_authentication");
Route::post('/disp_gotchas', 'App\Http\Controllers\Api\GotchaController@disp_gotchas')->name('post_disp_gotchas')->middleware("check_user_authentication");
Route::post('/gotcha_detail', 'App\Http\Controllers\Api\GotchaController@gotcha_detail')->name('post_gotcha_detail')->middleware("check_user_authentication");
Route::post('/gotcha_result', 'App\Http\Controllers\Api\GotchaController@gotcha_result')->name('post_gotcha_result')->middleware("check_user_authentication");