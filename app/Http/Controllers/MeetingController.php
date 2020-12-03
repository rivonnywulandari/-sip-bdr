<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Http\Resources\MeetingResource;

class MeetingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
/*    public function meetings($id)
    {
        $meeting = MeetingResource::collection(Meeting::with('lecturer_classroom')
                        ->where('lecturer_classroom_id', $id)
                        ->get());

        return $meeting;
    }
*/
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
        $this->validate($request, [
            'lecturer_classroom_id' => 'required',
            'number_of_meeting' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required',
        ]);

        $meeting = new Meeting;
        $meeting->lecturer_classroom_id = $request->lecturer_classroom_id;
        $meeting->number_of_meeting = $request->number_of_meeting;
        $meeting->date = $request->date;
        $meeting->start_time = $request->start_time;
        $meeting->finish_time = $request->finish_time;
        $meeting->save();

        return new MeetingResource($meeting);   
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        //
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
