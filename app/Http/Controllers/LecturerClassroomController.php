<?php

namespace App\Http\Controllers;

use App\Models\LecturerClassroom;
use Illuminate\Http\Request;
use App\Http\Resources\LecturerClassroomResource;

class LecturerClassroomController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturerClassroom = LecturerClassroomResource::collection(
            LecturerClassroom::where('lecturer_id', auth()->guard('api')->user()->id)
            ->get());

        return $lecturerClassroom;
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
