<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use Illuminate\Http\Request;
use App\Http\Resources\KrsResource;
use DB;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $krs = Krs::query()
            ->join('classrooms','classrooms.id','=','krs.classroom_id')
            ->join('courses', 'courses.id', '=', 'classrooms.course_id')
            ->join('periods', 'periods.id', '=', 'classrooms.period_id')
            ->select('krs.id', 'krs.classroom_id', 'classrooms.course_id', 'classrooms.classroom_code', 
            DB::raw('courses.name as course_name'), 'courses.sks', 'courses.course_code', 
            DB::raw("CONCAT(periods.semester, ' ', periods.year) AS period"))
            ->where('student_id', auth()->guard('api')->user()->id)
            ->groupBy('course_name')
            ->orderBy('periods.id', 'DESC')
            ->get();
  
        $response['krs'] = $krs;
        
        return response()->json($response);
    }
}
