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
    Route::get('/prize/create', 'App\Http\Controllers\PrizeController@create')->name('prize.create');
    Route::post('/prize/create', 'App\Http\Controllers\PrizeController@create')->name('post.prize.create');
    Route::get('/prize/{id}/edit', 'App\Http\Controllers\PrizeController@edit')->name('prize.edit');
    Route::post('/prize/edit', 'App\Http\Controllers\PrizeController@edit')->name('post.prize.edit');
    Route::get('/prize/{id}/delete', 'App\Http\Controllers\PrizeController@delete')->name('prize.delete');

    // Picture
    Route::get('/picture', 'App\Http\Controllers\PictureController@index')->name('picture');
    Route::get('/picture/create', 'App\Http\Controllers\PictureController@create')->name('picture.create');
    Route::post('/picture/create', 'App\Http\Controllers\PictureController@create')->name('post.picture.create');
    Route::get('/picture/{id}/edit', 'App\Http\Controllers\PictureController@edit')->name('picture.edit');
    Route::post('/picture/edit', 'App\Http\Controllers\PictureController@edit')->name('post.picture.edit');
    Route::get('/picture/{id}/delete', 'App\Http\Controllers\PictureController@delete')->name('picture.delete');
    Route::post('/picture/get', 'App\Http\Controllers\PictureController@getPicture')->name('picture.get');
    // Route::get('/picture/{id}/delete', ['as'=>'picture.delete', 'uses'=> 'PictureController@delete']);
// Route::post('/picture_edit', 'App\Http\Controllers\PictureController@edit_action');
// Route::get('/gotcha_register', 'App\Http\Controllers\GotchaController@register')->name('gotcha_register');
// Route::post('/gotcha_register', 'App\Http\Controllers\GotchaController@register')->name('gotcha_register');