<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Models\StudentLocation;
use App\Models\Krs;
use App\Models\Meeting;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Http\Resources\StudentAttendanceResource;

class StudentAttendanceController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showStudentAttendances($meeting_id)
    {   
        $studentAttendance = StudentAttendanceResource::collection(
                        StudentAttendance::join('meetings', 'meetings.id', '=', 'student_attendances.meeting_id')
                        ->join('lecturer_classrooms', 'lecturer_classrooms.id', '=', 'meetings.lecturer_classroom_id')
                        ->where('lecturer_id', auth()->guard('api')->user()->id)
                        ->where('meeting_id', $meeting_id)
                        ->get());

        return $studentAttendance;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datetime = Carbon::now();

        $meeting_id = Meeting::where('start_time', '<=', $datetime->toTimeString())
                    ->where('finish_time', '>=', $datetime->toTimeString())
                    ->where('date', $datetime->toDateString())
                    ->first();
        
        $krs_id = DB::table('krs')
                ->join('classrooms', 'krs.classroom_id', '=', 'classrooms.id')
                ->join('lecturer_classrooms', 'classrooms.id', '=', 'lecturer_classrooms.classroom_id')
                ->join('meetings', 'lecturer_classrooms.id', '=', 'meetings.lecturer_classroom_id')
                ->where('lecturer_classrooms.id', $meeting_id->lecturer_classroom_id)
                ->value('krs.id');

        $student_location_id = StudentLocation::where('student_id', auth()->guard('api')->user()->id)
                            ->where('submission_status', 'Disetujui')
                            ->value('id');

        if($meeting_id && $krs_id && $student_location_id) {
            $studentAttendance = new StudentAttendance;
            $studentAttendance->krs_id = $krs_id;
            $studentAttendance->meeting_id = $meeting_id->id;
            $studentAttendance->student_location_id = $student_location_id;
            $studentAttendance->presence_status = $request->presence_status;
            $studentAttendance->save();

            return new StudentAttendanceResource($studentAttendance);

        } else {
            $studentAttendance = new StudentAttendance;
            $studentAttendance->krs_id = $krs_id;
            $studentAttendance->meeting_id = $meeting_id->id;
            $studentAttendance->presence_status = 'Absen';
            $studentAttendance->save();

            return new StudentAttendanceResource($studentAttendance);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentAttendance = StudentAttendance::findOrFail($id);
        $studentAttendance->update($request->only('presence_status'));

        return new StudentAttendanceResource($studentAttendance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentAttendance $studentAttendance)
    {
        //
    }
}
