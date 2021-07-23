<?php

namespace App\Http\Controllers;

use App\Models\ClassroomSchedule;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Resources\ClassroomScheduleResource;

class ClassroomScheduleController extends Controller
{    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassroomSchedule  $classroomSchedule
     * @return \Illuminate\Http\Response
     */
    public function show($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);

        $schedules = $classroom->classroom_schedule()->get();
        $response['schedules'] = $schedules;
        
        return response()->json($response);
    }
}
