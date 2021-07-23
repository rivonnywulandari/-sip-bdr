<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Classroom;
use App\Helpers\Firebase;
use Illuminate\Http\Request;
use App\Http\Resources\MeetingResource;

class MeetingController extends Controller
{
    public function showMeetingNumber($classroom_id)
    {
        $meetingNumbers = Meeting::join('lecturer_classrooms', 'lecturer_classrooms.id', '=', 'meetings.lecturer_classroom_id')
                        ->where('lecturer_classrooms.classroom_id', $classroom_id)
                        ->select('number_of_meeting')
                        ->get();

        $response['meeting_numbers'] = $meetingNumbers;
        
        return response()->json($response);
    }

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
                'body' => 'Kelas telah dimulai. Ketuk untuk mengisi daftar hadir!',
                'type' => 'Reminder',
                'isScheduled' => "true",
                'scheduledTime' => "$meeting->date $meeting->start_time",
                'meetingId' => "$meeting->id",
                'date' => "$meeting->date",
                'startTime' => "$meeting->start_time",
                'finishTime' => "$meeting->finish_time",
            ]); 
        }

        return new MeetingResource($meeting);   
    }

    public function showLecturerMeetings($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);

        $meetings = $classroom->meeting()->orderBy('number_of_meeting')->get();
        $response['meetings'] = $meetings;
        
        return response()->json($response);
    }
    
    public function update(Request $request, Meeting $meeting)
    {
        $meeting->update($request->all());

        if ($meeting->save()) {
            $classroom_id = $meeting->lecturer_classroom->classroom_id;
            Firebase::sendNotificationToTopic($classroom_id, [
                'title' => 'Notifikasi Masuk Kelas',
                'body' => 'Kelas telah dimulai. Ketuk untuk mengisi daftar hadir!',
                'type' => 'Reminder',
                'isScheduled' => "true",
                'scheduledTime' => "$meeting->date $meeting->start_time",
                'meetingId' => "$meeting->id",
                'date' => "$meeting->date",
                'startTime' => "$meeting->start_time",
                'finishTime' => "$meeting->finish_time",
            ]); 
        }

        return new MeetingResource($meeting);
    }

    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);
        $meetingId = $meeting->id;
        $classroom_id = $meeting->lecturer_classroom->classroom_id;
        
        if ($meeting->delete()) {
            Firebase::sendNotificationToTopic($classroom_id, [
                'title' => 'Notifikasi Masuk Kelas',
                'body' => 'Kelas telah dimulai. Ketuk untuk mengisi daftar hadir!',
                'type' => 'Reminder',
                'isScheduled' => "true",
                'scheduledTime' => "0",
                'meetingId' => "$meetingId",
            ]); 
            return response()->json(['message'=>'Meeting has successfully deleted']);
        }

        if (!$meeting->delete()) {
            return response()->json(['error'=>'Meeting cannot be deleted']);
        }
    }
}
