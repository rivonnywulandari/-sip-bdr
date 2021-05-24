<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\LecturerClassroom;
use App\Models\Krs;
use App\Helpers\Firebase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\MeetingResource;

class MeetingController extends Controller
{
    public function showMeetingNumber($lecturer_classroom_id)
    {
        $meetingNumbers = Meeting::where('lecturer_classroom_id', $lecturer_classroom_id)
                        ->select('number_of_meeting')
                        ->get();

        $response['meeting_numbers'] = $meetingNumbers;
        
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createMeeting(Request $request, $lecturer_classroom_id)
    {
        $this->validate($request, [
            'number_of_meeting' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required',
            'topic' => 'required',
        ]);

        $meeting = new Meeting;
        $meeting->lecturer_classroom_id = $lecturer_classroom_id;
        $meeting->number_of_meeting = $request->number_of_meeting;
        $meeting->date = $request->date;
        $meeting->start_time = $request->start_time;
        $meeting->finish_time = $request->finish_time;
        $meeting->topic = $request->topic;

        if ($meeting->save()) {
            $classroom_id = $meeting->lecturer_classroom->classroom_id;
            Firebase::sendNotificationToTopic($classroom_id, [
                'title' => 'Notifikasi Masuk Kelas',
                'body' => 'Kelas telah dimulai. Jangan lupa isi daftar hadir!',
                'type' => 'Reminder',
                'isScheduled' => "true",
                'scheduledTime' => "$meeting->date $meeting->start_time",
            ]); 
        }

        return new MeetingResource($meeting);   
    }

    /**
     * Display list of meetings.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function showLecturerMeetings($lecturer_classroom_id)
    {
        $classroom = LecturerClassroom::findOrFail($lecturer_classroom_id);

        $meetings = $classroom->meeting()->orderBy('date')->get();
        $response['meetings'] = $meetings;
        
        return response()->json($response);
    }

    /**
     * Display list of meetings.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function showStudentMeetings($classroom_id)
    {
        $meetings = Meeting::join('lecturer_classrooms', 'lecturer_classrooms.id', '=', 'meetings.lecturer_classroom_id')
                ->join('classrooms', 'lecturer_classrooms.classroom_id', '=', 'classrooms.id')
                ->join('krs', 'classrooms.id', '=', 'krs.classroom_id')
                ->select('meetings.*')
                ->where('lecturer_classrooms.classroom_id', $classroom_id)
                ->where('krs.student_id', auth()->guard('api')->user()->id)
                ->orderBy('date')
                ->get();

        $response['meetings'] = $meetings;
        
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting)
    {
        $meeting->update($request->all());

        return new MeetingResource($meeting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);

        $meeting->delete();
        return response()->json(['message'=>'Meeting has successfully deleted']);

        if (!$meeting->delete()) {
            return response()->json(['error'=>'Meeting cannot be deleted']);
        }
    }
}
