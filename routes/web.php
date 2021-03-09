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
    Route::get('/gotcha', 'App\Http\Controllers\GotchaController@index')->name('gotcha');
    Route::get('/gotcha/create', 'App\Http\Controllers\GotchaController@create_index')->name('get_gotcha_create');
    Route::post('/gotcha/create', 'App\Http\Controllers\GotchaController@create_action')->name('post_gotcha_create');
    Route::get('/gotcha/edit', 'App\Http\Controllers\GotchaController@edit_index')->name('get_gotcha_edit');
    Route::post('/gotcha/edit', 'App\Http\Controllers\GotchaController@edit_action')->name('post_gotcha_edit');

    // Prize
    Route::get('/prize', 'App\Http\Controllers\PrizeController@index')->name('prize');
    Route::get('/prize/create', 'App\Http\Controllers\PrizeController@create_index')->name('get_prize_create');
    Route::post('/prize/create', 'App\Http\Controllers\PrizeController@create_action')->name('post_prize_create');
    Route::get('/prize/{id}/edit', 'App\Http\Controllers\PrizeController@edit_index')->name('prize_edit');
    Route::post('/prize/{id}/edit', 'App\Http\Controllers\PrizeController@edit_action')->name('prize_edit');

    // Picture
    Route::get('/picture', 'App\Http\Controllers\PictureController@index')->name('picture');
    Route::get('/picture/create', 'App\Http\Controllers\PictureController@create')->name('get_picture_create');
    Route::post('/picture/create', 'App\Http\Controllers\PictureController@create')->name('post_picture_create');
    Route::get('/picture/{id}/edit', 'App\Http\Controllers\PictureController@edit')->name('picture.edit');
    Route::post('/picture/{id}/edit', 'App\Http\Controllers\PictureController@edit')->name('post.picture.edit');
    Route::get('/picture/{id}/delete', 'App\Http\Controllers\PictureController@delete')->name('picture.delete');
    // Route::get('/picture/{id}/delete', ['as'=>'picture.delete', 'uses'=> 'PictureController@delete']);
// Route::post('/picture_edit', 'App\Http\Controllers\PictureController@edit_action');
// Route::get('/gotcha_register', 'App\Http\Controllers\GotchaController@register')->name('gotcha_register');
// Route::post('/gotcha_register', 'App\Http\Controllers\GotchaController@register')->name('gotcha_register');