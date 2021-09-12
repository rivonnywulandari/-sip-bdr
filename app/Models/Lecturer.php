<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [ 
        'id',
        'name',
        'nip'
    ];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function student(){
        return $this->hasMany('App\Models\Student');
    }

    public function lecturer_classroom(){
        return $this->hasMany('App\Models\LecturerClassroom');
    }

    public function classroom(){
        return $this->belongsToMany('App\Models\Classroom', 'lecturer_classrooms', 'classroom_id', 'lecturer_id');
    }

    public function student_location()
    {
        return $this->hasManyThrough('App\Models\StudentLocation', 'App\Models\Student', 'lecturer_id', 'student_id');
    }
}
