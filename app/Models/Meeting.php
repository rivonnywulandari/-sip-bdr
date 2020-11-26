<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'number_of_meeting', 
        'date', 
        'start_time', 
        'finish_time', 
        'lecturer_classroom_id'
    ];

    public function lecturer_classroom(){
        return $this->belongsTo('App\Models\LecturerClassroom');
    }

    public function student_attendance(){
        return $this->hasMany('App\Models\StudentAttendance');
    }
}
