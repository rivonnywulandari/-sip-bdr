<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\LecturerClassroom;
use App\Models\Krs;
use Illuminate\Http\Request;
use App\Http\Resources\MeetingResource;

class MeetingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createMeeting(Request $request, $classroom_id)
    {
        $lecturer_classroom_id = LecturerClassroom::where('lecturer_id', auth()->guard('api')->user()->id)
                                ->where('classroom_id', $classroom_id)
                                ->value('id');

        $this->validate($request, [
            'number_of_meeting' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required',
        ]);

        $meeting = new Meeting;
        $meeting->lecturer_classroom_id = $lecturer_classroom_id;
        $meeting->number_of_meeting = $request->number_of_meeting;
        $meeting->date = $request->date;
        $meeting->start_time = $request->start_time;
        $meeting->finish_time = $request->finish_time;
        $meeting->save();

        return new MeetingResource($meeting);   
    }

    /**
     * Display list of meetings.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function showLecturerMeetings($classroom_id)
    {
        $lecturer_classroom_id = LecturerClassroom::where('lecturer_id', auth()->guard('api')->user()->id)
                    ->where('classroom_id', $classroom_id)
                    ->value('id');

        $classroom = LecturerClassroom::findOrFail($lecturer_classroom_id);

        $meetings = $classroom->meeting()->get();
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
        $krs_id = Krs::where('student_id', auth()->guard('api')->user()->id)
                    ->where('classroom_id', $classroom_id)
                    ->value('id');

        $classroom = LecturerClassroom::findOrFail($krs_id);

        $meetings = $classroom->meeting()->get();
        $response['meetings'] = $meetings;
        
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        return new MeetingResource($meeting);
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
    public function destroy(Meeting $meeting)
    {
        //
    }
}
