<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentLocationResource extends JsonResource
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
            'longitude'=> $this->longitude,
            'latitude' => $this->latitude,
            'address'=> $this->address,
            'student_id'=> $this->student,
            'submission_status'=> $this->submission_status,
        ];
    }
}
