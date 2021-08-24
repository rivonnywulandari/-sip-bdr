<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\LecturerClassroom;
use App\Models\Krs;
use App\Models\StudentAttendance;
use App\Models\Period;
use App\Models\Course;
use App\Models\ClassroomSchedule;
use Illuminate\Http\Request;
use App\Http\Resources\ClassroomResource;
use App\Imports\ClassroomImport;
use Excel;

class ClassroomController extends Controller
{   
    public function index()
    {
        $classrooms = Classroom::orderBy('period_id', 'DESC')->paginate(15);

        return view('classroom.index', compact('classrooms'));
    }

    public function import(Request $request) {
        $this->validate($request, [
            'report_file'  => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('report_file');
        $path = $file->storeAs('public/data_kelas', $file->getClientOriginalName());
        Excel::import(new ClassroomImport, $path);
        return back()->with('success', 'Excel data successfully imported.');
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
                ->rightJoin('krs', 'krs.id', 'student_attendances.krs_id')
                ->rightJoin('students', 'students.id', 'krs.student_id')
                ->select('student_attendances.id as att_id', 'presence_status', 'students.name as student_name', 'students.nim', 'meetings.date')
                ->where('classroom_id', $id)
                ->groupBy('meetings.date', 'students.name')
                ->orderBy('nim')
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
            return view('classroom.show', compact('classroom', 'lecturers', 's_attendances', 'presence', 'date_temp'));
        }
    }

    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);

        $periods = Period::all()->sortByDesc('id')->pluck('period','id');
        $courses = Course::all()->pluck('course','id');
        $codes = ['A'=>'A', 'B'=>'B'];
        
        return view('classroom.edit', compact('classroom', 'periods', 'courses', 'codes'));
    }

    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $request->validate([
            'course_id'=>'required',
            'classroom_code'=>'required',
            'period_id'=>'required'
        ]);

    	$classroom->course_id = $request->course_id;
        $classroom->classroom_code = $request->classroom_code;
        $classroom->period_id = $request->period_id;

        if ($classroom->save()) {
            return redirect()->route('classroom.index')->with('success', 'Data successfully updated.');
        }
    }

    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $krs = Krs::where('classroom_id', $id)->get();
        $lecturer_classroom = LecturerClassroom::where('classroom_id', $id)->get();
        $schedule = ClassroomSchedule::where('classroom_id', $id)->get();

        if ($krs->isEmpty() && $lecturer_classroom->isEmpty() && $schedule->isEmpty()) {
            $classroom->delete();
            return redirect()->route('classroom.index')->with('success', 'Data successfully deleted.');    
        } else {
            return redirect()->route('classroom.index')
                ->with('error', "Data cannot be deleted because it's being referenced by other data.");
        } 
    }
}
