<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLocation extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'student_id', 
        'longitude', 
        'latitude', 
        'address', 
        'submission_status'
    ];
    
    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function student_attendance(){
        return $this->hasMany('App\Models\StudentAttendance');
    }
}
