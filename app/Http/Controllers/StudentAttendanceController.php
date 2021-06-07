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
                        ->orderBy('students.nim')
                        ->get();

        $response['studentattendance'] = $studentAttendance;
        
        return response()->json($response);
    }

    public function showAttendances($krs_id)
    {   
        $attendance = StudentAttendance::join('meetings', 'meetings.id', '=', 'student_attendances.meeting_id')
                        ->where('krs_id', $krs_id)
                        ->select('meetings.*', 'presence_status')
                        ->orderBy('date')
                        ->get();

        $response['attendance'] = $attendance;

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $student_location_id = StudentLocation::where('student_id', auth()->guard('api')->user()->id)
                            ->where('submission_status', 'Disetujui')
                            ->value('id');

        $studentAttendance = new StudentAttendance;
        $studentAttendance->student_location_id = $student_location_id;
        $studentAttendance->meeting_id = $request->meeting_id;
        
        // Getting krs_id
        $meeting = Meeting::findOrFail($studentAttendance->meeting_id);
        $krs_id = Krs::where('student_id', auth()->guard('api')->user()->id)
                ->where('classroom_id', $meeting->lecturer_classroom->classroom_id)                    
                ->value('id');
        $studentAttendance->krs_id = $krs_id;
        $studentAttendance->presence_status = $request->presence_status;
        if ($studentAttendance->presence_status == "Absen") {
            $studentAttendance->needs_review = 1;
        }
        $studentAttendance->save();

        $response['attendance'] = new StudentAttendanceResource($studentAttendance);

        return response()->json($response);
    }

   public function update(Request $request, $id)
    {
        $studentAttendance = StudentAttendance::findOrFail($id);
        $studentAttendance->update($request->only('presence_status'));

        return new StudentAttendanceResource($studentAttendance);
    }

    public function updateReviewStatus(Request $request, $meeting_id)
    {
        $student_location_id = StudentLocation::where('student_id', auth()->guard('api')->user()->id)
                ->where('submission_status', 'Disetujui')
                ->value('id');
        $stuAttendance = StudentAttendance::where('student_location_id', $student_location_id)
                ->where('meeting_id', $meeting_id)
                ->first();
        $stuAttendance->update($request->only('needs_review'));
    
        return new StudentAttendanceResource($stuAttendance);
    }
}
