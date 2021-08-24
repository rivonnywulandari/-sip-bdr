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
	Route::get('home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::get('home/classrooms/{id?}', 'App\Http\Controllers\HomeController@classrooms')->name('select-classroom');
	Route::post('home', 'App\Http\Controllers\HomeController@store')->name('home.store');

	// Routes for period management
	Route::get('period', 'App\Http\Controllers\PeriodController@index')->name('period.index');  
	Route::get('period/create', 'App\Http\Controllers\PeriodController@create')->name('period.create'); 
	Route::post('period', 'App\Http\Controllers\PeriodController@store')->name('period.store');
	Route::get('period/{id}/edit', 'App\Http\Controllers\PeriodController@edit')->name('period.edit');
	Route::patch('period/{period}', 'App\Http\Controllers\PeriodController@update')->name('period.update');
	Route::delete('period/{id}', 'App\Http\Controllers\PeriodController@destroy')->name('period.destroy');

	// Routes for course management
	Route::get('course', 'App\Http\Controllers\CourseController@index')->name('course.index');  
	Route::get('course/create', 'App\Http\Controllers\CourseController@create')->name('course.create'); 
	Route::post('course', 'App\Http\Controllers\CourseController@store')->name('course.store');
	Route::get('course/{id}/edit', 'App\Http\Controllers\CourseController@edit')->name('course.edit');
	Route::patch('course/{course}', 'App\Http\Controllers\CourseController@update')->name('course.update');
	Route::delete('course/{id}', 'App\Http\Controllers\CourseController@destroy')->name('course.destroy');

	// Routes for classroom management
	Route::get('classroom', 'App\Http\Controllers\ClassroomController@index')->name('classroom.index');  
	Route::post('classroom/import', 'App\Http\Controllers\ClassroomController@import')->name('classroom.import'); 
	Route::get('classroom/{id}/edit', 'App\Http\Controllers\ClassroomController@edit')->name('classroom.edit');
	Route::patch('classroom/{classroom}', 'App\Http\Controllers\ClassroomController@update')->name('classroom.update');
	Route::delete('classroom/{id}', 'App\Http\Controllers\ClassroomController@destroy')->name('classroom.destroy');
	Route::get('classroom/{id}/{action}', 'App\Http\Controllers\ClassroomController@showDetail')->name('classroom.show');
	
	// Routes for profile page
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	// Routes for pages
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
