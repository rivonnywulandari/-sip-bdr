<?php

namespace App\Http\Controllers;

use App\Models\LecturerClassroom;
use Illuminate\Http\Request;
use App\Http\Resources\LecturerClassroomResource;
use DB;

class LecturerClassroomController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturerClassroom = LecturerClassroom::join('classrooms','classrooms.id','=','lecturer_classrooms.classroom_id')
            ->join('classroom_schedules','classroom_schedules.classroom_id','=','classrooms.id')
            ->join('courses', 'courses.id', '=', 'classrooms.course_id')
            ->select('lecturer_classrooms.id', 'classrooms.course_id', 'classrooms.classroom_code', DB::raw('courses.name as course_name'), 
            'courses.sks', 'classroom_schedules.scheduled_day', 'classroom_schedules.start_time', 'classroom_schedules.finish_time', 'classroom_schedules.classroom_id')
            ->where('lecturer_id', auth()->guard('api')->user()->id)
            ->get();

        // $lecturers = LecturerClassroom::join('lecturers','lecturers.id','=','lecturer_classrooms.lecturer_id')
        //     ->select('lecturer_classrooms.id', 'lecturers.*')
        //     ->get();
            
        $response['lecturerclassrooms'] = $lecturerClassroom;
        //$response['lecturers'] = $lecturers;
        
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LecturerClassroom  $lecturerClassroom
     * @return \Illuminate\Http\Response
     */
    public function show(LecturerClassroom $lecturerClassroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LecturerClassroom  $lecturerClassroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LecturerClassroom $lecturerClassroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LecturerClassroom  $lecturerClassroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(LecturerClassroom $lecturerClassroom)
    {
        //
    }
}
