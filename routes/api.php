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

/*
Route::get('/', function () {
    return [
        'app' => config('app.name'),
        'version' => '1.0.0',
    ];
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//  Authentication
Route::post('api/register', 'AuthController@register')->name('api.register');
Route::post('api/login', 'AuthController@login')->name('api.login');

Route::group(['middleware' => 'api'], function () {
    //  Authentication
    Route::middleware('jwt.auth')->get('api/logout', 'AuthController@logout')->name('api.logout');
    Route::get('api/user', 'AuthController@getAuthUser')->name('api.user');

    // Classroom Schedule
    Route::apiResource('api/schedule', 'ClassroomScheduleController'); // for retrieving classroom schedule

    // Student Classroom
    Route::apiResource('api/student', 'StudentController');
    Route::apiResource('api/krs', 'KrsController'); //for retrieving student classrooms

    // Lecturer Classroom
    Route::apiResource('api/lecturerclassroom','LecturerClassroomController'); // for retrieving lecturer classrooms

    // Classroom Detail
    Route::apiResource('api/classroom', 'ClassroomController'); // for retrieving classroom detail

    // Student Location Submission
    Route::apiResource('api/studentlocation', 'StudentLocationController');
    Route::get('api/studentsubmission', 'StudentLocationController@showStudentSubmissions'); // for retrieving student location submissions

    // Meeting
    Route::apiResource('api/meeting', 'MeetingController')->except('index', 'store');
    Route::get('api/lecturermeetings/{id}', 'MeetingController@showLecturerMeetings');
    Route::get('api/studentmeetings/{id}', 'MeetingController@showStudentMeetings');
    Route::post('api/meeting/{id}', 'MeetingController@createMeeting');

    //Student Attendances
    Route::apiResource('api/studentattendance', 'StudentAttendanceController')->except('index');
    Route::get('api/classattendance/{id}', 'StudentAttendanceController@showStudentAttendances');
    Route::get('api/attendance/{student}', 'StudentController@showAttendances');
});

