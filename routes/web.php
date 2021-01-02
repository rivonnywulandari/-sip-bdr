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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'App\Http\Controllers\HomeController@index');

// Routes for authentication
Auth::routes();
Route::post('login/verify', 'App\Http\Controllers\Auth\LoginController@verify')->name('login-verify');

// Routes for Home page
Route::get('dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard');
Route::get('dashboard/classrooms/{id?}', 'App\Http\Controllers\HomeController@classrooms')->name('select-classroom');
Route::post('dashboard', 'App\Http\Controllers\HomeController@store')->name('dashboard.store');

//Routes for classroom detail page
Route::get('classroom/{id}/{action}', 'App\Http\Controllers\ClassroomController@showDetail')->name('classroom.show');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
