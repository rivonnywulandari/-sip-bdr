<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    public function period(){
        return $this->belongsTo('App\Models\Period');
    }

    public function course(){
        return $this->belongsTo('App\Models\Course');
    }

    public function lecturer_classroom(){
        return $this->hasMany('App\Models\LecturerClassroom');
    }

    public function student(){
        return $this->belongsToMany('App\Models\Student', 'krs', 'student_id', 'classroom_id');
    }

    public function lecturer(){
        return $this->belongsToMany('App\Models\Lecturer', 'krs', 'lecturer_id', 'classroom_id');
    }

    public function krs(){
        return $this->hasMany('App\Models\Krs');
    }

    public function classroom_schedule(){
        return $this->hasMany('App\Models\ClassroomSchedule');
    }

    public function meeting()
    {
        return $this->hasManyThrough('App\Models\Meeting', 'App\Models\LecturerClassroom', 'classroom_id', 'lecturer_classroom_id');
    }
}
