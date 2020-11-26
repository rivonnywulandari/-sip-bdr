<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomScheduleResource extends JsonResource
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
            'scheduled_day'=> $this->scheduled_day,
            'start_time'=> $this->start_time,
            'finish_time'=> $this->finish_time,
            'classroom_id'=> $this->classroom,
        ];
    }
}
