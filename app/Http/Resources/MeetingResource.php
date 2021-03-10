<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
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
            'number_of_meeting'=> $this->number_of_meeting,
            'date'=> $this->date->format('d-m-Y'),
            'start_time'=> $this->start_time->format('H:i'),
            'finish_time'=> $this->finish_time->format('H:i'),
            'lecturer_classroom_id'=> $this->lecturer_classroom,
        ];
    }
}
