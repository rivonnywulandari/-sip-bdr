<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Krs;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Resources\StudentAttendanceResource;

class StudentAttendanceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showStudentAttendances($classroom_id)
    {
        $user_id = Auth::user()->id;
        $lecturer_id = Lecturer::where('id' ,'>', 0)->pluck('id')->toArray();
        
        if(in_array($user_id, $lecturer_id)) {
            $studentAttendance = StudentAttendanceResource::collection(StudentAttendance::with('meeting', 'krs', 'student_location')
                            ->join('meetings', 'meetings.id', '=', 'student_attendances.meeting_id')
                            ->join('lecturer_classrooms', 'lecturer_classrooms.id', '=', 'meetings.lecturer_classroom_id')
                            ->where('lecturer_id', auth()->guard('api')->user()->id)
                            ->where('classroom_id', $classroom_id)
                            ->get());

            return $studentAttendance;
        }
        else{}
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
        $user_id = Auth::user()->id;
        $student_id = Student::where('id' ,'>', 0)->pluck('id')->toArray();

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

        $student_location_id = studentAttendance::where('student_id', $user_id)
                            ->where('submission_status', 'Disetujui')
                            ->value('id');

        if(in_array($user_id, $student_id)) {
            if($meeting_id && $krs_id && $student_location_id)
            {
                $studentAttendance = new StudentAttendance;
                $studentAttendance->krs_id = $krs_id;
                $studentAttendance->meeting_id = $meeting_id->id;
                $studentAttendance->student_location_id = $student_location_id;
                $studentAttendance->presence_status = $request->presence_status;
                $studentAttendance->save();
            }
            

            return new StudentAttendanceResource($studentAttendance);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
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
        $user_id = Auth::user()->id;
        $lecturer_id = Lecturer::where('id' ,'>', 0)->pluck('id')->toArray();

        if(in_array($user_id, $lecturer_id)) {
            $studentAttendance = StudentAttendance::findOrFail($id);
            $studentAttendance->update($request->only('presence_status'));

            return new StudentAttendanceResource($studentAttendance);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
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
