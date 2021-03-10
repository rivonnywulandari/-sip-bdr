<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\LecturerClassroom;
use App\Models\Krs;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use App\Http\Resources\ClassroomResource;

class ClassroomController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function showDetail($id, $action=null)
    {
        $classroom = Classroom::findOrFail($id);
        $lecturers = LecturerClassroom::where('classroom_id', $id)->get();
        $dates = StudentAttendance::join('meetings', 'meetings.id', 'student_attendances.meeting_id')
                ->join('krs', 'krs.id', 'student_attendances.krs_id')
                ->where('classroom_id', $id)
                ->groupBy('meetings.date')
                ->get();

        $s_attendances = StudentAttendance::join('meetings', 'meetings.id', 'student_attendances.meeting_id')
                ->join('krs', 'krs.id', 'student_attendances.krs_id')
                ->join('students', 'students.id', 'krs.student_id')
                ->select('student_attendances.id as att_id', 'presence_status', 'students.name as student_name', 'students.nim', 'meetings.date')
                ->where('classroom_id', $id)
                ->groupBy('meetings.date', 'students.name')
                ->get();
        
        $presence = [];
        $students_temp = [];
        $date_temp = [];

        foreach ($dates as  $date) {
            $date_temp[] = ['id' => $date->att_id, 'date' => $date->date];
        }

        foreach ($s_attendances as  $s_attendance) {
            $temp = null;

            if (!in_array($s_attendance->nim, $students_temp)) {
                array_push($students_temp, $s_attendance->nim);
                  foreach ($s_attendances as $s_attendance_2) {
                     if ($s_attendance->nim == $s_attendance_2->nim) {   
                        if ($temp == null) {
                            $temp['nim'] = $s_attendance_2->nim;
                            $temp['student_name'] = $s_attendance_2->student_name;
                            $temp['desc'] = [[
                                'date' => $s_attendance_2->date, 
                                'presence_status' => $s_attendance_2->presence_status, 
                                'id' => $s_attendance_2->att_id
                                ]]; 
                        } else {
                            array_push($temp['desc'], ['date' => $s_attendance_2->date, 'presence_status' => $s_attendance_2->presence_status, 'id' => $s_attendance_2->att_id]);
                        }
                    }
                }   
                array_push($presence, $temp);   
            }
        }
        
        if($action == 'print') {
            return view('classroom.print', compact('classroom', 'lecturers', 's_attendances', 'presence', 'date_temp'));
        } 
        else {
            return view('classroom.index', compact('classroom', 'lecturers', 's_attendances', 'presence', 'date_temp'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        //
    }
}
