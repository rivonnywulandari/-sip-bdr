<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'student_id',
        'classroom_id'
    ];

    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function classroom(){
        return $this->belongsTo('App\Models\Classroom');
    }

    public function student_attendance(){
        return $this->hasMany('App\Models\StudentAttendance');
    }
}
