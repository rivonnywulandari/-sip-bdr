<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'krs_id'=> $this->krs,
            'meeting_id'=> $this->meeting,
            'student_location_id'=> $this->student_location,
            'presence_status'=> $this->presence_status,
            'needs_review'=> $this->needs_review,
        ];
    }
}
