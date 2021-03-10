<?php

namespace App\Http\Controllers;

use App\Models\StudentLocation;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\StudentLocationResource;

class StudentLocationController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $studentLocation = StudentLocation::join('students', 'students.id', '=', 'student_locations.student_id')
                        ->where('student_id', auth()->guard('api')->user()->id)
                        ->select('student_locations.*', 'students.name', 'students.nim')
                        ->orderBy('submission_status', 'ASC')
                        ->orderBy('created_at', 'DESC')
                        ->get();

        $response['studentlocation'] = $studentLocation;
        
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
        $user_id = auth()->guard('api')->user()->id;

        $this->validate($request, [
            'longitude' => 'required',
            'latitude' => 'required',
            'address' => 'required',
        ]);

        $studentLocation = new StudentLocation;
        $studentLocation->student_id = $user_id;
        $studentLocation->longitude = $request->longitude;
        $studentLocation->latitude = $request->latitude;
        $studentLocation->address = $request->address;
        $studentLocation->submission_status = "Belum Disetujui";
        $studentLocation->save();

        return new StudentLocationResource($studentLocation);
    }

    /**
     * Display list of student location submissions.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function showStudentSubmissions()
    {
        $user_id = auth()->guard('api')->user()->id;
        $lecturer = Lecturer::findOrFail($user_id);
        $studentLocation = $lecturer->student_location()
                        ->select('student_locations.*', 'students.name', 'students.nim')
                        ->orderBy('submission_status', 'ASC')
                        // ->where('submission_status', '!=', 'Disetujui')
                        ->get();

        $response['studentlocation'] = $studentLocation;
        
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentLocation  $studentLocation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentLocation = StudentLocation::join('students', 'students.id', '=', 'student_locations.student_id')
                        ->select('student_locations.*', 'students.name', 'students.nim')
                        ->where('student_locations.id', $id)
                        ->get();

        $response['studentlocation'] = $studentLocation;
        
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $studentLocation = StudentLocation::findOrFail($id);
        $studentLocation->update($request->only('submission_status'));

        return new StudentLocationResource($studentLocation);
    }

    public function updateByStudent(Request $request, $id)
    {
        $studentLocation = StudentLocation::findOrFail($id);
        $studentLocation->update($request->all());

        return new StudentLocationResource($studentLocation);
    }
 
    public function destroy($id)
    {
        $studentLocation = StudentLocation::findOrFail($id);

        // Schema::disableForeignKeyConstraints();
        // $studentLocation->delete();
        // Schema::enableForeignKeyConstraints();
        // return response()->json(['message'=>'Submission has successfully deleted']);

        $studentLocation->delete();
        return response()->json(['message'=>'Location has successfully deleted']);

        if (!$studentLocation->delete()) {
            return response()->json(['error'=>'Location cannot be deleted']);
        }
    }
}
