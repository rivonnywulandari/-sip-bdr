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

// Routes for authentication
Auth::routes();
Route::post('login/verify', 'App\Http\Controllers\Auth\LoginController@verify')->name('login-verify');

Route::group(['middleware' => 'admin'], function () {
	// Routes for Home page
	Route::get('/', 'App\Http\Controllers\HomeController@index');
	Route::get('dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard');
	Route::get('dashboard/classrooms/{id?}', 'App\Http\Controllers\HomeController@classrooms')->name('select-classroom');
	Route::post('dashboard', 'App\Http\Controllers\HomeController@store')->name('dashboard.store');

	// Routes for classroom detail page
	Route::get('classroom/{id}/{action}', 'App\Http\Controllers\ClassroomController@showDetail')->name('classroom.show');

	// Routes for profile page
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	// Routes for pages
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
