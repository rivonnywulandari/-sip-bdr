<?php

namespace App\Http\Controllers;

use App\Models\StudentLocation;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Helpers\Firebase;
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
        $student = Student::findOrFail($user_id);
        $receiver = User::findOrFail($student->lecturer_id);

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

        if ($studentLocation->save()) {
            Firebase::sendNotificationToUID($receiver->fcm_token, [
                'title' => 'Notifikasi Pengajuan',
                'body' => 'Pengajuan lokasi baru menunggu di-follow up!',
                'type' => 'Updates',
            ]); 
        }

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
    public function showLatLng()
    {
        $latlng = StudentLocation::select('latitude', 'longitude')
                        ->where('student_id', auth()->guard('api')->user()->id)
                        ->where('submission_status', 'Disetujui')
                        ->first();
        
        return response()->json([
            'location' => [
              'latlng' => $latlng
            ]
          ]);
    }

    public function update(Request $request, $id)
    {
        $studentLocation = StudentLocation::findOrFail($id);
        $receiver = User::findOrFail($studentLocation->student_id);

        $accepted_location = StudentLocation::where('student_id', $studentLocation->student_id)
                            ->where('submission_status', 'Disetujui')
                            ->count();

        if ($request->submission_status == "Disetujui") {
            if ($accepted_location == 0) {
                $studentLocation->update($request->only('submission_status'));
                if ($studentLocation->update()) {
                    Firebase::sendNotificationToUID($receiver->fcm_token, [
                        'title' => 'Notifikasi Pengajuan',
                        'body' => 'Pengajuan lokasi Anda telah diterima!',
                        'type' => 'Updates',
                    ]); 
                    $response['location'] = new StudentLocationResource($studentLocation);
                    return response()->json($response);
                }
            } else {
                return response()->json(['error'=>'Nonaktifkan lokasi yang disetujui sebelumnya terlebih dahulu.'], 403);
            } 
        } else if ($request->submission_status == "Ditolak") {
            $studentLocation->update($request->only('submission_status'));
            if ($studentLocation->update()) {
                Firebase::sendNotificationToUID($receiver->fcm_token, [
                    'title' => 'Notifikasi Pengajuan',
                    'body' => 'Pengajuan lokasi Anda telah ditolak.',
                    'type' => 'Updates',
                ]); 
                $response['location'] = new StudentLocationResource($studentLocation);
                return response()->json($response);
            }
        } else {
            $studentLocation->update($request->only('submission_status'));
            if ($studentLocation->update()) {
                $response['location'] = new StudentLocationResource($studentLocation);
                return response()->json($response);
            }
        }
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
        $studentLocation->delete();
        
        return response()->json(['message'=>'Location has successfully deleted']);

        if (!$studentLocation->delete()) {
            return response()->json(['error'=>'Location cannot be deleted']);
        }
    }
}
