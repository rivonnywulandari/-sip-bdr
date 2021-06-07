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
        $lecturerClassroom = LecturerClassroom::query()
            ->join('classrooms','classrooms.id','=','lecturer_classrooms.classroom_id')
            ->join('courses', 'courses.id', '=', 'classrooms.course_id')
            ->join('periods', 'periods.id', '=', 'classrooms.period_id')
            ->select('lecturer_classrooms.id', 'lecturer_classrooms.classroom_id', 'classrooms.course_id', 'classrooms.classroom_code', DB::raw('courses.name as course_name'), 
            'courses.sks', 'courses.course_code', 
            DB::raw("CONCAT(periods.semester, ' ', periods.year) AS period"))
            ->where('lecturer_id', auth()->guard('api')->user()->id)
            ->groupBy('course_name')
            ->orderBy('periods.id', 'DESC')
            ->get();

        $response['lecturerclassrooms'] = $lecturerClassroom;
        
        return response()->json($response);
    }
}
