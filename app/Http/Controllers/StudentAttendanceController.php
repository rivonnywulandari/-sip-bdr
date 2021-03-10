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
    public function showStudentAttendances($meeting_id)
    {   
        $studentAttendance = StudentAttendance::join('krs', 'krs.id', '=', 'student_attendances.krs_id')
                        ->join('students', 'students.id', '=', 'krs.student_id')
                        ->where('meeting_id', $meeting_id)
                        ->select('student_attendances.id', 'students.name', 'students.nim', 'presence_status')
                        ->get();

        $response['studentattendance'] = $studentAttendance;
        
        return response()->json($response);
    }

    public function showAttendances($krs_id)
    {   
        $attendance = StudentAttendance::join('meetings', 'meetings.id', '=', 'student_attendances.meeting_id')
                        ->where('krs_id', $krs_id)
                        ->select('student_attendances.id', 'meetings.number_of_meeting', 'meetings.date',
                         'meetings.start_time','meetings.finish_time', 'presence_status')
                        ->get();

        $response['attendance'] = $attendance;
        
        return response()->json($response);
    }

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

    public function show(StudentAttendance $studentAttendance)
    {
        //
    }

   public function update(Request $request, $id)
    {
        $studentAttendance = StudentAttendance::findOrFail($id);
        $studentAttendance->update($request->only('presence_status'));

        return new StudentAttendanceResource($studentAttendance);
    }

    public function destroy(StudentAttendance $studentAttendance)
    {
        //
    }
}
