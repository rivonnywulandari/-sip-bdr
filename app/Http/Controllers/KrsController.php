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
        $krs = Krs::join('classrooms','classrooms.id','=','krs.classroom_id')
            ->join('courses', 'courses.id', '=', 'classrooms.course_id')
            ->select('krs.id', 'krs.classroom_id', 'classrooms.course_id', 'classrooms.classroom_code', 
            DB::raw('courses.name as course_name'), 'courses.sks', 'courses.course_code')
            ->where('student_id', auth()->guard('api')->user()->id)
            ->groupBy('course_name')
            ->get();
  
        $response['krs'] = $krs;
        
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
     * @param  \App\Models\Krs  $krs
     * @return \Illuminate\Http\Response
     */
    public function show(Krs $krs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Krs  $krs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Krs $krs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Krs  $krs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Krs $krs)
    {
        //
    }
}
