<?php

namespace App\Http\Controllers;

use App\Models\StudentLocation;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Auth;
use App\Http\Resources\StudentLocationResource;

class StudentLocationController extends Controller
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
        $studentLocation = StudentLocationResource::collection(
                        StudentLocation::where('student_id', auth()->guard('api')->user()->id)
                        ->get());

        return $studentLocation;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

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
        $user_id = Auth::user()->id;
        $lecturer = Lecturer::findOrFail($user_id);
        $studentLocation = $lecturer->student_location()
                        ->where('submission_status', '!=', 'Disetujui')
                        ->orWhereNull('submission_status')
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
        $studentLocation = StudentLocation::findOrFail($id);
        return new StudentLocationResource($studentLocation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentLocation  $studentLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentLocation = StudentLocation::findOrFail($id);
        $studentLocation->update($request->only('submission_status'));

        return new StudentLocationResource($studentLocation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentLocation  $studentLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentLocation = StudentLocation::findOrFail($id);

        Schema::disableForeignKeyConstraints();
        $studentLocation->delete();
        Schema::enableForeignKeyConstraints();
        return response()->json(['message'=>'Submission has successfully deleted']);
    }
}
