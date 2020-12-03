<?php

namespace App\Http\Controllers;

use App\Models\StudentLocation;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
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
        $user_id = Auth::user()->id;
        $student_id = Student::where('id' ,'>', 0)->pluck('id')->toArray();
        
        if(in_array($user_id, $student_id)) {
            $studentLocation = StudentLocationResource::collection(StudentLocation::with('student')
                            ->where('student_id', auth()->guard('api')->user()->id)
                            ->get());

            return $studentLocation;
        }
        else{
            //
        }
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
        $user_id = Auth::user()->id;
        $student_id = Student::where('id' ,'>', 0)->pluck('id')->toArray();

        if(in_array($user_id, $student_id)) {
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
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentLocation  $studentLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentLocation $studentLocation)
    {
        //
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
        $user_id = Auth::user()->id;
        $lecturer_id = Lecturer::where('id' ,'>', 0)->pluck('id')->toArray();

        if(in_array($user_id, $lecturer_id)) {
            $studentLocation = StudentLocation::findOrFail($id);
            $studentLocation->update($request->only('submission_status'));

            return new StudentLocationResource($studentLocation);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentLocation  $studentLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $student_id = Student::where('id' ,'>', 0)->pluck('id')->toArray();
        $student_attendance = StudentAttendance::where('id' ,'>', 0)->pluck('student_location_id')->toArray();

        if(in_array($user_id, $student_id)) {
            if(in_array($id, $student_attendance)) {
                return response()->json(['error' => 'Location cannot be deleted because it has been approved'], 422);
            }
            else {
                $studentLocation = StudentLocation::findOrFail($id);
                $studentLocation->delete();
                return response()->json(['message'=>'Submission has successfully deleted']);
            }
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
