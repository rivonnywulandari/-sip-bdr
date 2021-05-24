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


Route::get('api', function () {
    return [
        'app' => config('app.name'),
        'version' => '1.0.0',
    ];
});

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//  Authentication
Route::post('api/register', 'AuthController@register')->name('api.register');
Route::post('api/login', 'AuthController@login')->name('api.login');
Route::get('api/islogin', 'AuthController@isLogin')->name('api.islogin');

Route::group(['middleware' => 'api'], function () {
    //  Authentication
    Route::middleware('jwt.auth')->get('api/logout', 'AuthController@logout')->name('api.logout');
    Route::get('api/user', 'AuthController@getAuthUser')->name('api.user');
    Route::put('api/changepassword', 'AuthController@changePassword')->name('api.changepassword');

    // Student Classroom
    Route::apiResource('api/krs', 'KrsController'); // for retrieving student classrooms

    // Lecturer Classroom
    Route::apiResource('api/lecturerclassroom','LecturerClassroomController'); // for retrieving lecturer classrooms

    // Classroom Schedules
    Route::apiResource('api/schedules','ClassroomScheduleController'); // for retrieving classroom schedules

    // Student Location Submission
    Route::apiResource('api/studentlocation', 'StudentLocationController');
    Route::get('api/studentsubmission', 'StudentLocationController@showStudentSubmissions'); // for retrieving student location submissions
    Route::put('api/editlocation/{id}', 'StudentLocationController@updateByStudent'); // for editing student's location submission
    Route::get('api/latlng', 'StudentLocationController@showLatLng'); // for retrieving student location latlng

    // Meeting
    Route::apiResource('api/meeting', 'MeetingController')->except('index', 'store');
    Route::get('api/lecturermeetings/{id}', 'MeetingController@showLecturerMeetings');
    Route::get('api/studentmeetings/{classroom_id}', 'MeetingController@showStudentMeetings');
    Route::post('api/meeting/{id}', 'MeetingController@createMeeting');
    Route::get('api/meetingnumber/{lecturer_classroom_id}', 'MeetingController@showMeetingNumber');

    //Student Attendances
    Route::apiResource('api/studentattendance', 'StudentAttendanceController')->except('index');
    Route::patch('api/needsreview/{krs_id}/{meeting_id}', 'StudentAttendanceController@updateReviewStatus'); // update whether student needs review or not
    Route::get('api/classattendance/{id}', 'StudentAttendanceController@showStudentAttendances'); // retrieving student attendances for lecturer
    Route::get('api/attendance/{id}', 'StudentAttendanceController@showAttendances'); // retrieving student attendances for student
});

